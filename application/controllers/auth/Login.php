<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('google');

        if ($this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('profile', 'refresh');
        }
    }

    public function index()
    {
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() === TRUE)
        {
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/', 'refresh');
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh');
            }
        }
        else
        {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );
            $this->data['loginURL'] = $this->google->loginURL();

            $this->load->view('auth/login', $this->data);
        }
    }

    public function google_auth()
    {
        if(isset($_GET['code'])) {
            try{
                $this->google->getAuthenticate();
            } catch (Exception $e) {
                redirect('auth/login');
            }
            //get user info from google
            $gpInfo = $this->google->getUserInfo();

            if($this->ion_auth->email_check($gpInfo['email'])) {
                $this->ion_auth->google_login($gpInfo['email']);
                redirect('profile');
            } else {
                $data['google_info'] = $gpInfo;
                $this->load->view('header',$data);
                $this->load->view('auth/google_register');
                $this->load->view('footer');
            }
        }
    }
}
