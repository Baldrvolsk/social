<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public $user;
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
        if(!file_exists('./uploads/profile/'.$this->user->id))
        {
            $this->user->photo = '/uploads/profile/blank.jpeg';
        } else {
            $photos = scandir('./uploads/profile/'.$this->user->id);

            $this->user->photo = '/uploads/profile'.end($photos);

        }

    }

    public function index($id = 0) {
        if($id != 0) {
            $data['user'] = $this->ion_auth->user((int)$id)->row();
        } else {
            $data['user'] = $this->user;
        }
        if(!file_exists('./uploads/profile/'.$this->user->id))
        {
            $this->user->photo = '/uploads/profile/blank.jpeg';
        } else {
            $photos = scandir('./uploads/profile/' . $data['user']->id);
            $data['user']->photo = '/uploads/profile/'.end($photos);
        }
        $formData['userId'] = $this->user->id;
        $data['addPostForm'] = $this->load->view('post/add_post', $formData,true);
        $postData['posts'] = $this->post_model->get_users_post($data['user']->id, 5);
        $data['posts'] = $this->load->view('post/view_post', $postData,true);
        $this->load->view('header', $data);
        $this->load->view('profile');
        $this->load->view('footer');
    }

}
