<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function register($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    
    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        
        return false;
    }
    
    public function check_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
    
    public function check_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
    
    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function update_profile($user_id, $data) {
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0;
    }

    public function change_password($user_id, $new_password) {
        $data = array(
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        );
        
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0;
    }

    public function check_password($user_id, $password) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            return password_verify($password, $user->password);
        }
        
        return false;
    }

    public function update_profile_picture($user_id, $picture_path) {
        $data = array(
            'profile_picture' => $picture_path
        );
        
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0;
    }
}