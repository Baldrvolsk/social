<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in() or !$this->ion_auth->is_admin())
        {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Админка';
        $data['active'] = 'index';
        $this->load->view('admin/header',$data);
		$this->load->view('admin/index');
        $this->load->view('admin/footer');
	}
}
