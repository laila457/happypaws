<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
}