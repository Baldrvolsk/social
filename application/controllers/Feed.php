<?php


class Feed extends CI_Controller
{
    public $user;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
    }

    public function index() {
        $debug = array();
        $this->theme
            ->title('Лента новостей')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('common/in_dev');
    }
}