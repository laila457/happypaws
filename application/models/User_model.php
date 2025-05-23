<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function count_users() {
        return $this->db->count_all('users');
    }

    public function get_recent_users() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('users')->result();
    }

    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }
}