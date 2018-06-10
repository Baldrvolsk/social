<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if($this->ion_auth->logged_in())
        {
            redirect('profile');
        }
    }

    public function index()
	{
        $this->load->view('header');
		$this->load->view('default_layout');
        $this->load->view('footer');
	}
}
