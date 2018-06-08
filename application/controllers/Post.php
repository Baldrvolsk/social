<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:04
 */

class Post extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('comment_model');
    }

    public function index()
    {
        $data['news'] = $this->news_model->get_news();
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);
    }
}