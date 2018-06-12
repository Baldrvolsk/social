<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public $user;
    public function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('chat/chat');
        $this->load->view('footer');
    }
}
