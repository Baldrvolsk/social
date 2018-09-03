<?php


class Rating extends CI_Controller
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
            ->load('common/in_dev');
    }
}