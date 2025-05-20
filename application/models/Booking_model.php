<?php
defined('BASEPATH') OR exit('No direct script 
allowed');

class Booking_model extends CI_Model {
    
    public function get_grooming_history($user_id) {
        $this->db->where('nama_pemilik', $this->session->userdata('username'));
        $this->db->order_by('tanggal_grooming', 'DESC');
        return $this->db->get('grooming')->result();
    }
    
    public function get_penitipan_history($user_id) {
        $this->db->where('nama_pemilik', $this->session->userdata('username'));
        $this->db->order_by('check_in', 'DESC');
        return $this->db->get('penitipan')->result();
    }
    
    public function get_grooming_by_id($booking_id) {
        $this->db->where('id', $booking_id);
        return $this->db->get('grooming')->row();
    }
    
    public function get_penitipan_by_id($booking_id) {
        $this->db->where('id', $booking_id);
        return $this->db->get('penitipan')->row();
    }
    
    public function count_bookings($type) {
        if ($type === 'grooming') {
            return $this->db->count_all_results('grooming');
        } else if ($type === 'penitipan') {
            return $this->db->count_all_results('penitipan');
        }
        return 0;
    }

    public function get_recent_grooming() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('grooming')->result();
    }

    public function get_recent_penitipan() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('penitipan')->result();
    }

    public function get_all_grooming() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('grooming')->result();
    }

    public function get_all_penitipan() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('penitipan')->result();
    }

    public function update_status($booking_id, $type, $status) {
        $table = ($type === 'grooming') ? 'grooming' : 'penitipan';
        
        $data = ['status' => $status];
        
        $this->db->where('id', $booking_id);
        return $this->db->update($table, $data);
    }
}