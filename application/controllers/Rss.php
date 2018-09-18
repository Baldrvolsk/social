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
		
		$this->load->helper('xml');
        $this->load->helper('text');
		
    }

    public function index() {
        $debug = array();
		
		/*$data['feed_name'] = 'rusimperia.ru';
        $data['encoding'] = 'utf-8';
        $data['feed_url'] = 'https://rusimperia.ru/feed';
        $data['page_description'] = 'RusImperia социальная сеть.';
        $data['page_language'] = 'ru-ru';
        $data['creator_email'] = 'zakazhi.website@gmail.com';*/
        
        //header("Content-Type: application/rss+xml");
		
        $this->theme
            ->title('Лента новостей')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('common/in_dev');
    }
}