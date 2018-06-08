<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public $user;
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
        print_r($this->user);die();
        $photos = scandir('./uploads/profile/'.$this->user->id);
        $this->user->photo = end($photos);
    }

    public function index()
    {
      $this->load->view('header');
      $this->load->view('profile');
      $this->load->view('footer');
    }

}
