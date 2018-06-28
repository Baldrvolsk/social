<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->ion_auth->logged_in())
        {
            redirect('profile');
        }
        $this->load->library('google');
    }

    public function index() {
        $data['loginURL'] = $this->google->loginURL();

        $this->load->view('header',$data);
		$this->load->view('default_layout');
        $this->load->view('footer');
	}
}
