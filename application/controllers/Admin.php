<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('booking_model');
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Admin Dashboard';
        $data['username'] = $this->session->userdata('username');
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
        
        $result = $this->booking_model->update_booking_status($booking_id, $type, $status);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function get_dashboard_counts() {
        $data = [
            'grooming_count' => $this->booking_model->count_bookings('grooming'),
            'penitipan_count' => $this->booking_model->count_bookings('penitipan')
        ];
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}