<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Load required models
        $this->load->model('user_model');
        $this->load->model('booking_model');
        
        // Redirect admin to admin dashboard
        if ($this->session->userdata('role') == 'admin') {
            redirect('admin/dashboard');
        }
    }
    
    public function index() {
        $data['title'] = 'User Dashboard';
        $data['username'] = $this->session->userdata('username');
        
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('dashboard/footer');
    }
    
    public function layanan() {
        $data['title'] = 'Layanan';
        $data['username'] = $this->session->userdata('username');
        
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/layanan');
        $this->load->view('dashboard/footer');
    }
    
    public function grooming() {
        $data['title'] = 'Grooming';
        $data['username'] = $this->session->userdata('username');
        
        // Get rebook data if exists
        $rebook_data = $this->session->userdata('rebook_data');
        if ($rebook_data) {
            $data['rebook'] = $rebook_data;
            $this->session->unset_userdata('rebook_data');
        }
        
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/grooming', $data);
        $this->load->view('dashboard/footer');
    }
    
    public function penitipan() {
        $data['title'] = 'Penitipan';
        $data['username'] = $this->session->userdata('username');
        
        // Get rebook data if exists
        $rebook_data = $this->session->userdata('rebook_data');
        if ($rebook_data) {
            $data['rebook'] = $rebook_data;
            $this->session->unset_userdata('rebook_data');
        }
        
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/penitipan', $data);
        $this->load->view('dashboard/footer');
    }

    public function rebook($type, $booking_id) {
        $booking = $this->db->get_where($type == 'grooming' ? 'grooming' : 'penitipan', ['id' => $booking_id])->row();
        
        if (!$booking) {
            redirect('dashboard/akun');
        }
        
        // Keep only specific data for rebooking
        $rebook_data = new stdClass();
        
        // Common data for both types
        $rebook_data->nama_pemilik = $booking->nama_pemilik;
        $rebook_data->no_hp = $booking->no_hp;
        $rebook_data->jenis_hewan = $booking->jenis_hewan;
        
        // Add delivery and address data
        $rebook_data->pengantaran = $booking->pengantaran;
        $rebook_data->kecamatan = $booking->kecamatan;
        $rebook_data->desa = $booking->desa;
        $rebook_data->detail_alamat = $booking->detail_alamat;
        
        // Type specific data
        if ($type == 'grooming') {
            $rebook_data->paket_grooming = $booking->paket_grooming;
        } else {
            // For penitipan, include pet name
            $rebook_data->nama_hewan = $booking->nama_hewan;
        }
        
        // Store booking data in session for pre-filling the form
        $this->session->set_userdata('rebook_data', $rebook_data);
        
        // Redirect to appropriate booking page
        redirect('dashboard/' . $type);
    }
    
    public function akun() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user_by_id($user_id);
        $data['grooming_history'] = $this->booking_model->get_grooming_history($user_id);
        $data['penitipan_history'] = $this->booking_model->get_penitipan_history($user_id);
        
        $this->load->view('dashboard/akun', $data);
    }
    
    public function update_profile() {
        if (!$this->session->userdata('logged_in')) {
            $this->output->set_status_header(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $data = [
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address')
        ];

        $this->load->model('user_model');
        if ($this->user_model->update_profile($user_id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Profil berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui profil']);
        }
    }

    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            $this->output->set_status_header(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $current_password = $this->input->post('currentPassword');
        $new_password = $this->input->post('newPassword');
        $confirm_password = $this->input->post('confirmPassword');

        if ($new_password !== $confirm_password) {
            echo json_encode(['status' => 'error', 'message' => 'Password baru tidak cocok']);
            return;
        }

        $this->load->model('user_model');
        if (!$this->user_model->verify_password($user_id, $current_password)) {
            echo json_encode(['status' => 'error', 'message' => 'Password saat ini tidak valid']);
            return;
        }

        if ($this->user_model->change_password($user_id, $new_password)) {
            echo json_encode(['status' => 'success', 'message' => 'Password berhasil diubah']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah password']);
        }
    }
    
    public function upload_profile_picture() {
        // Create directory if not exists
        $upload_path = './uploads/profile_pictures/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
    
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('profilePicture')) {
            $response = array(
                'status' => 'error',
                'message' => $this->upload->display_errors('', '')
            );
        } else {
            $upload_data = $this->upload->data();
            $profile_picture = 'uploads/profile_pictures/' . $upload_data['file_name'];
    
            // Update database
            $this->db->where('id', $this->session->userdata('user_id'));
            $update = $this->db->update('users', array('profile_picture' => $profile_picture));
    
            if ($update) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Foto profil berhasil diperbarui'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal memperbarui foto profil'
                );
            }
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function calculate_total_harga($selected_package) {
        $package_prices = [
            'basic' => 50000,
            'kutu' => 70000,
            'full' => 85000
        ];

        return isset($package_prices[$selected_package]) ? $package_prices[$selected_package] : 0;
    }
    
    public function submit_grooming() {
        // Capture form data
        $selected_date = $this->input->post('selected_date');
        $time = $this->input->post('time');
        $nama = $this->input->post('nama');
        $hp = $this->input->post('hp');
        $petType = $this->input->post('petType');
        $selected_package = $this->input->post('selected_package');
        $delivery = $this->input->post('delivery');
        $kecamatan = $this->input->post('kecamatan');
        $desa = $this->input->post('desa');
        $detail_alamat = $this->input->post('detail_alamat');
        
        // Set default payment method to 'pending' if not provided
        $paymentMethod = $this->input->post('paymentMethod');
        if (empty($paymentMethod)) {
            $paymentMethod = 'pending'; // User will pay later
        }
    
        $totalHarga = $this->calculate_total_harga($selected_package, $delivery);
    
        $data = [
            'tanggal_grooming' => $selected_date,
            'waktu_booking' => $time,
            'nama_pemilik' => $nama,
            'no_hp' => $hp,
            'jenis_hewan' => $petType,
            'paket_grooming' => $selected_package,
            'pengantaran' => $delivery,
            'kecamatan' => $kecamatan,
            'desa' => $desa,
            'detail_alamat' => $detail_alamat,
            'metode_pembayaran' => $paymentMethod,
            'total_harga' => $totalHarga,
            'bukti_transaksi' => null
        ];
    
        $insert = $this->db->insert('grooming', $data);
    
        if ($insert) {
            $booking_id = $this->db->insert_id();
            redirect('dashboard/payment/' . $booking_id . '/grooming');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data. Silakan coba lagi.');
            redirect('dashboard/grooming');
        }
    }
    public function process_penitipan() {
        // Process the form data
        $data = array(
            'check_in' => $this->input->post('check_in'),
            'check_out' => $this->input->post('check_out'),
            'nama_pemilik' => $this->input->post('nama_pemilik'),
            'no_hp' => $this->input->post('no_hp'),
            'nama_hewan' => $this->input->post('nama_hewan'),
            'jenis_hewan' => $this->input->post('jenis_hewan'),
            'paket_penitipan' => $this->input->post('paket'),
            'pengantaran' => $this->input->post('pengantaran'),
            'kecamatan' => $this->input->post('kecamatan'),
            'desa' => $this->input->post('desa'),
            'detail_alamat' => $this->input->post('detail_alamat'),
            'catatan' => $this->input->post('catatan'),
            'total_harga' => $this->calculate_total_price(),
            'metode_pembayaran' => 'pending'
        );
    
        $this->db->insert('penitipan', $data);
        $booking_id = $this->db->insert_id();
    
        echo json_encode([
            'success' => true,
            'booking_id' => $booking_id
        ]);
    }
    
    private function calculate_total_price() {
        $check_in = new DateTime($this->input->post('check_in'));
        $check_out = new DateTime($this->input->post('check_out'));
        $interval = $check_in->diff($check_out);
        $days = $interval->days + 0; // Include both check-in and check-out days
        
        $package_prices = [
            'regular' => 50000,
            'premium' => 75000
        ];
        
        $selected_package = $this->input->post('paket');
        $rate = $package_prices['premium'];
        if ($selected_package === 'regular') {
            $rate = $package_prices['regular'];
        }
        
        return $days * $rate;
    }

    public function payment($id = null) {
        if (!$id) {
            redirect('dashboard');
        }
    
        // Check if it's a grooming or penitipan booking
        $data['booking'] = $this->db->get_where('grooming', ['id' => $id])->row();
        if (!$data['booking']) {
            $data['booking'] = $this->db->get_where('penitipan', ['id' => $id])->row();
            $data['type'] = 'penitipan';
        } else {
            $data['type'] = 'grooming';
        }
    
        if (!$data['booking']) {
            redirect('dashboard');
        }
    
        $this->load->view('dashboard/payment', $data);
    }

    public function confirm_payment($booking_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Get booking type from session or post
        $type = $this->input->post('type') ?? 'grooming';
        
        // Configure upload settings
        $config['upload_path'] = './assets/uploads/payments/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('transactionProof')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('dashboard/payment/' . $booking_id . '/' . $type);
        } else {
            $upload_data = $this->upload->data();
            $file_path = 'assets/uploads/payments/' . $upload_data['file_name'];
            
            $payment_method = $this->input->post('paymentMethod');
            
            $data = array(
                'metode_pembayaran' => $payment_method,
                'bukti_transaksi' => $file_path
            );
            
            // Update the correct table based on booking type
            $table = ($type === 'penitipan') ? 'penitipan' : 'grooming';
            
            $this->db->where('id', $booking_id);
            $update = $this->db->update($table, $data);
            
            if ($update) {
                $this->load->view('dashboard/payment_success');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data pembayaran.');
                redirect('dashboard/payment/' . $booking_id . '/' . $type);
            }
        }
    }

    public function invoice($id, $type) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    
        // Validate type parameter
        if (!in_array($type, ['grooming', 'penitipan'])) {
            show_404();
        }

        $data['type'] = $type;
        
        // Get booking data based on type
        if ($type === 'grooming') {
            $data['booking'] = $this->db->get_where('grooming', ['id' => $id])->row();
            if (!$data['booking']) {
                show_404();
            }
        } else {
            $data['booking'] = $this->db->get_where('penitipan', ['id' => $id])->row();
            if (!$data['booking']) {
                show_404();
            }
        }
    
        $this->load->view('dashboard/invoice', $data);
    }
}