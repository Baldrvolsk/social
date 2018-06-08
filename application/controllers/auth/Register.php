<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('login', 'Логин', 'required|min_length[5]|is_unique[users.username]');
        $this->form_validation->set_rules('first_name', 'Имя', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Пароль', 'required|min_length[4]');
        $this->form_validation->set_rules('password_confirm', 'Подтверждение пароля', 'required|min_length[4]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('auth/register');
            $this->load->view('footer');
        } else {
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
            );
            $group = array('2');
            // load success template...
            $this->ion_auth->register($this->input->post('login'), $this->input->post('password'), $this->input->post('email'),$additional_data , $group);
            $this->load->view('auth/success');

        }
    }
}
