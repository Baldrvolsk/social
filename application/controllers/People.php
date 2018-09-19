<?php

class People extends CI_Controller
{
    public $user;
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->model('people_model');
        $this->lang->load('profile');
    }

    public function index() {
        $data['people'] = $this->people_model->get_people($this->user->id);
        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Данные',
                'c' => var_debug($data)
            );
        }
        $this->theme
            ->title('Люди')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('user/people', $data);
    }
}