<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class By_default extends CI_Controller
{

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->ion_auth->logged_in()) {
            redirect('profile/'.$this->session->user_id, 'refresh');
        } else {
            $this->load->library('google');
            $data['loginURL'] = $this->google->loginURL();
            $this->theme
                ->master('auth')
                ->layout('auth')
                ->title('Страница авторизации')
                ->add_partial('auth_header')
                ->load('auth/login', $data);
        }
    }
}
