<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:04
 */

class Post extends CI_Controller
{
    private $user;
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('comment_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $htis->user = $this->ion_auth->user()->row();
    }

    public function index() {

        $data['posts'] = $this->post_model->get_users_post($this->user->id);

    }

    public function view($id = NULL) {
        if ($id === null) return array();
        $data['post'] = $this->post_model->get_post($id);
    }

    public function add_post_form() {
        $this->load->helper('form');
        $data['user_id'] = $this->user->id;
        return $this->load->view('post/add_post', $data, TRUE);
    }
}