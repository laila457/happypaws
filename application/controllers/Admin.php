<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('booking_model');
        $this->load->model('user_model'); // Add this line
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Admin Dashboard';
        $data['username'] = $this->session->userdata('username');
        $data['users_count'] = $this->user_model->count_users();
        $data['recent_users'] = $this->user_model->get_recent_users(); // Add this line
        $data['grooming_count'] = $this->booking_model->count_bookings('grooming');
        $data['penitipan_count'] = $this->booking_model->count_bookings('penitipan');
        $data['recent_grooming'] = $this->booking_model->get_recent_grooming();
        $data['recent_penitipan'] = $this->booking_model->get_recent_penitipan();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }

    public function grooming() {
        $data['title'] = 'Kelola Grooming';
        $data['bookings'] = $this->booking_model->get_all_grooming();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/grooming', $data);
        $this->load->view('admin/footer');
    }

    public function penitipan() {
        $data['title'] = 'Kelola Penitipan';
        $data['bookings'] = $this->booking_model->get_all_penitipan();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/penitipan', $data);
        $this->load->view('admin/footer');
    }

    public function update_status() {
        $booking_id = $this->input->post('booking_id');
        $type = $this->input->post('type');
        $status = $this->input->post('status');
        
        $table = ($type === 'penitipan') ? 'penitipan' : 'grooming';
        
        $this->db->where('id', $booking_id);
        $update = $this->db->update($table, ['status' => $status]);
        
        if ($update) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    // Add a new method to get updated status data
    public function get_status_data() {
        $booking_id = $this->input->get('booking_id');
        $type = $this->input->get('type');
        
        if (!$booking_id || !$type) {
            echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
            return;
        }
        
        $data = null;
        if ($type === 'grooming') {
            $data = $this->booking_model->get_grooming_by_id($booking_id);
        } else if ($type === 'penitipan') {
            $data = $this->booking_model->get_penitipan_by_id($booking_id);
        }
        
        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data not found']);
        }
    }

    // Add a method to get dashboard counts for real-time updates
    public function get_dashboard_counts() {
        $grooming_count = $this->booking_model->count_bookings('grooming');
        $penitipan_count = $this->booking_model->count_bookings('penitipan');
        
        echo json_encode([
            'success' => true,
            'grooming_count' => $grooming_count,
            'penitipan_count' => $penitipan_count
        ]);
    }

    public function delete_booking($type, $id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $table = $type === 'grooming' ? 'grooming' : 'penitipan';
        
        $this->db->where('id', $id);
        $result = $this->db->delete($table);
        
        $response = [
            'success' => $result ? true : false,
            'message' => $result ? 'Successfully deleted' : 'Failed to delete'
        ];
        
        echo json_encode($response);
    }
}