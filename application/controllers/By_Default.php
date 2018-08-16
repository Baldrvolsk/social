<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default extends CI_Controller
{

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->ion_auth->logged_in()) {
            redirect('profile');
        } else {
            $this->load->library('google');
            $data['loginURL'] = $this->google->loginURL();

            $this->load->view('header',$data);
		    $this->load->view('auth/login');
            $this->load->view('footer');
        }
    }
}
