<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        $this->load->model('user_model');
    }

    public function index() {
        $data['title'] = 'Users Management';
        $data['users'] = $this->user_model->get_all_users();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/users/list', $data);
        $this->load->view('admin/footer');
    }

    public function create() {
        $data['title'] = 'Add New User';

        if ($this->input->post()) {
            $config['upload_path'] = './uploads/profiles/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            $userData = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => $this->input->post('role')
            ];

            if ($this->upload->do_upload('profile_picture')) {
                $uploadData = $this->upload->data();
                $userData['profile_picture'] = $uploadData['file_name'];
            }

            if ($this->user_model->create_user($userData)) {
                $this->session->set_flashdata('success', 'User successfully created');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user');
            }
        }

        $this->load->view('admin/header', $data);
        $this->load->view('admin/users/create', $data);
        $this->load->view('admin/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['user'] = $this->user_model->get_user($id);

        if ($this->input->post()) {
            $userData = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => $this->input->post('role')
            ];

            if ($this->input->post('password')) {
                $userData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            if ($_FILES['profile_picture']['name']) {
                $config['upload_path'] = './uploads/profiles/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('profile_picture')) {
                    $uploadData = $this->upload->data();
                    $userData['profile_picture'] = $uploadData['file_name'];
                }
            }

            if ($this->user_model->update_user($id, $userData)) {
                $this->session->set_flashdata('success', 'User successfully updated');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user');
            }
        }

        $this->load->view('admin/header', $data);
        $this->load->view('admin/users/edit', $data);
        $this->load->view('admin/footer');
    }

    public function delete($id) {
        if ($this->user_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User successfully deleted');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }
        redirect('admin/users');
    }
}