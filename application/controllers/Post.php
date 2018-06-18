<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:04
 */

class Post extends CI_Controller
{
    public $user;
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('comment_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
        $photos = scandir('./uploads/profile/'.$this->user->id);

        $this->user->photo = end($photos);
    }

    public function index($userId, $limit) {
        $data['posts'] = $this->post_model->get_users_post($userId, $limit);
        echo $this->load->view('post/view_post', $data, TRUE);
    }

    public function view($id = NULL) {
        if ($id === null) return array();
        $data['post'] = $this->post_model->get_post($id);
    }

    public function add_post_form() {
        $this->load->helper('form');
        $data['user_id'] = $this->user->id;
        $this->load->view('post/add_post', $data, TRUE);
    }

    public function add_post($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('content', 'content', 'required|min_length[3]');

        if ($this->form_validation->run() === FALSE) {
            $formData['userId'] = $id;
            $data['addPostForm'] = $this->load->view('post/add_post', $formData,true);
            $this->load->view('header', $data);
            $this->load->view('profile');
            $this->load->view('footer');

        } else {
            $this->post_model->createPost((int)$id);
            $url = 'profile'.(($id === $this->user->id)?'':'/'.$id);
            log_message('debug', 'redirect add_post to '.$url);
            redirect($url);
        }
    }

    public function add_like($post_id, $user_id = null) {

    }

    public function add_dislike($post_id, $user_id = null) {

    }
}