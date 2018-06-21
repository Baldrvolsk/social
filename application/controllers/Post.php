<?php


class Post extends CI_Controller
{
    public $user;
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('comment_model');
        $this->comment_model->set_type('post');

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index($userId, $limit) {
        $data['posts'] = $this->post_model->get_users_post($userId, $limit);
        echo $this->load->view('post/index', $data, TRUE);
    }

    public function view($id = NULL) {
        if ($id === null) return array();
        return $this->post_model->get_post($id);
    }

    public function add_post_form() {
        $this->load->helper('form');
        $data['user_id'] = $this->user->id;
        $this->load->view('post/add', $data, TRUE);
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
            $this->post_model->create_post((int)$id);
            $url = 'profile'.(($id === $this->user->id)?'':'/'.$id);
            redirect($url);
        }
    }

    public function add_like($user_id = null, $post_id = null) {
        $ret = null;
        if ($post_id !== null && $user_id !== null) {
            $ret = $this->post_model->add_update_like('up', $post_id, $user_id);
        }
        echo json_encode($ret);
    }

    public function add_dislike($user_id = null, $post_id = null) {
        $ret = null;
        if ($post_id !== null && $user_id !== null) {
            $ret = $this->post_model->add_update_like('down', $post_id, $user_id);
        }
        echo json_encode($ret);
    }

    public function comment($post_id){
        $data['post'] = $this->view($post_id);
        $data['comment'] = $this->get_comments($post_id);
        $data['add_comment_form'] = $this->add_comment_form($post_id);
        $ret = $this->load->view('post/view', $data, TRUE);
        echo $ret;
    }

    public function get_comments($post_id, $limit = null, $offset = null) {
        $limit = (is_int($limit))?$limit:3;
        $offset = (is_int($offset))?$offset:0;
        $data['comments'] = $this->comment_model->get_comments($post_id, $limit, $offset);
        return $this->load->view('post/view_comment', $data, TRUE);
    }

    public function add_comment_form($post_id) {
        $this->load->helper('form');
        $data['postId'] = $post_id;
        return $this->load->view('post/add_comment', $data, TRUE);
    }

    public function add_comment($post_id) {
        $this->session->set_flashdata('show_post', (int)$post_id, 15);
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('content', 'content', 'required|min_length[3]');

        if ($this->form_validation->run() === FALSE) {
            $form_error = $this->form_validation->error_string();
            $this->session->set_tempdata('form_error', $form_error, 15);
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            $this->session->unset_tempdata('form_error');
            $this->comment_model->create_comment((int)$post_id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}