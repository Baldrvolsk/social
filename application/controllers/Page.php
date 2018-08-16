<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('page_model');
    }

    public function index($page_id) {
        $page = $this->page_model->get_page($page_id);
        $data['h'] = $page->head;
        $data['content'] = $page->content;
        $this->theme
            ->title($page->title)
            ->keywords($page->keywords)
            ->description($page->descr)
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer')
            ->load('common/page', $data);
    }
}