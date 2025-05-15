<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function update_profile($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    
    public function change_password($user_id, $new_password) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
    }
    
    public function verify_password($user_id, $current_password) {
        $user = $this->db->where('id', $user_id)->get('users')->row();
        if ($user) {
            return password_verify($current_password, $user->password);
        }
        return false;
    }
    
    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }
}