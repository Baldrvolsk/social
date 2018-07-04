<?php


class Balance extends CI_Controller
{
    public $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('group_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('balance/index');
        $this->load->view('footer');
    }
}