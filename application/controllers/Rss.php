<?php

class Rss extends CI_Controller
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
    	
        $data['RSS'] = $this->get_rss();	
        $debug = array();
		
        $this->theme
            ->title('Настройка RSS')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('common/rss', $data);
    }
	
	public function get_rss() {
		return array('test'=>'1');
	}
}