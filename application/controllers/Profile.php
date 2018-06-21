<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public $user;
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('post_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();


    }

    public function index($id = 0) {
        if($id != 0) {
            $data['userdata'] = $this->ion_auth->user((int)$id)->row();
        } else {
            $data['userdata'] = $this->user;
        }
        $formData['userId'] = $data['userdata']->id;
        $data['addPostForm'] = $this->load->view('post/add', $formData,true);
        if(!file_exists('./uploads/profile/'.$data['userdata']->id))
        {
            $data['userdata']->photo = '/img/blank.jpeg';
        } else {
            $photos = scandir('./uploads/profile/' . $data['userdata']->id);
            $data['userdata']->photo = '/uploads/profile/' . $data['userdata']->id.'/'.end($photos);
        }

        $postData['posts'] = $this->post_model->get_users_post($data['userdata']->id, 5);
        $data['posts'] = $this->load->view('post/index', $postData,true);
        $this->load->view('header', $data);
        $this->load->view('profile');
        $this->load->view('footer');
    }

    public function edit() {
        $this->form_validation->set_rules('first_name', 'Имя', 'required|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->user;
            $this->load->view('header', $data);
            $this->load->view('profile_edit');
            $this->load->view('footer');
        } else {
            $id = $this->user->id;
            $data['first_name'] = $this->input->post('first_name');
            $data['last_name'] = $this->input->post('last_name');
            $this->ion_auth->update($id, $data);
            redirect('/profile');
        }
    }

}
