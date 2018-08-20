<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        if ($this->ion_auth->logged_in()) {
            // redirect to default page
            redirect($this->config->item('site_default_page'), 'refresh');
        }
        $this->load->library('google');
        $this->load->library('theme');
    }

    public function index() {
        $data['loginURL'] = $this->google->loginURL();

        $this->theme
            ->master('auth')
            ->layout('auth')
            ->title('Страница авторизации')
            ->add_partial('auth_header')
            ->load('auth/login', $data);
    }

    public function auth_pass() {
        if (!DEBUG) return;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('identity',
                                          str_replace(':', '', $this->lang->line('login_identity_label')),
                                          'required');
        $this->form_validation->set_rules('password',
                                          str_replace(':', '', $this->lang->line('login_password_label')),
                                          'required');

        if ($this->form_validation->run() === TRUE) {
            $remember = (bool)$this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/', 'refresh');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh');
            }
        } else {
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['identity'] = array('name' => 'identity',
                                      'id' => 'identity',
                                      'type' => 'text',
                                      'value' => $this->form_validation->set_value('identity'),
            );
            $data['password'] = array('name' => 'password',
                                      'id'   => 'password',
                                      'type' => 'password',
            );
            $data['loginURL'] = $this->google->loginURL();

            $this->load->view('auth/login', $data);
        }
    }

    public function google_auth() {
        if (isset($_GET['code'])) {
            try {
                $this->google->getAuthenticate();
            } catch (Exception $e) {
                redirect('auth/login');
            }
            //get user info from google
            $gpInfo = $this->google->getUserInfo();

            if ($this->ion_auth->email_check($gpInfo['email'])) {
                $this->ion_auth->google_login($gpInfo['email']);
                redirect('profile');
            } else {
                if (empty($gpInfo['gender'])) $gpInfo['gender'] = null;
                $data['google_info'] = $gpInfo;
                $tmp = explode('@', $gpInfo['email']);
                $data['google_info']['login'] = current($tmp);

                $this->theme
                    ->title('Страница регистрации')
                    ->add_partial('header')
                    ->add_partial('l_sidebar')
                    ->add_partial('r_sidebar')
                    ->add_partial('footer')
                    ->load('auth/register', $data);
            }
        } else {
            redirect('auth/login');
        }
    }
}