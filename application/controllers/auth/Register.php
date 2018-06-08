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
        if (empty($_FILES['photo']['name']))
        {
            $this->form_validation->set_rules('photo', 'Фото', 'required');
        }
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
            $user_id = $this->ion_auth->register($this->input->post('login'), $this->input->post('password'), $this->input->post('email'),$additional_data , $group);

            mkdir('./uploads/profile/'.$user_id,0755);

            $config['upload_path'] = './uploads/profile/'.$user_id;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = 'active';
            $config['max_size'] = 100;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('photo'))
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);die();
                #die('error');
               # $this->load->view('upload_form', $error);
            }
            else
            {
                #die('good');
                $data = array('upload_data' => $this->upload->data());

                #$this->load->view('upload_success', $data);
            }
            $this->load->view('auth/success');

        }
    }
}
