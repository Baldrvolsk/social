<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in() or !$this->ion_auth->is_admin())
        {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Пользователи';
        $data['active'] = 'users';
        $data['users'] = $this->ion_auth->users()->result();
        $this->load->view('admin/header',$data);
        $this->load->view('admin/users');
        $this->load->view('admin/footer');
    }
}
