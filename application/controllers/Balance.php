<?php


class Balance extends CI_Controller
{
    public $user;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('', 'refresh');
        }
        $this->load->library('form_validation');
        $this->load->model('balance_model');

        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $debug = array();
        $this->theme
            ->title('Рейтинги')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('balance/index');
    }

    public function add($user_id) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('leptas', 'leptas', 'required|min_length[1]|max_length[5]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header');
            $this->load->view('balance/index');
            $this->load->view('footer');

        } else {
            $comment = 'Начисление с тестовой странички';
            $result = $this->balance_model->add_balance($user_id, $this->input->post('leptas', true), $comment);
            if ($result) {
                $url = 'profile';
                redirect($url);
            } else {
                $this->load->view('header');
                $this->load->view('balance/index');
                $this->load->view('footer');
            }
        }
    }
}