<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('photos_model');
        $this->load->library('form_validation');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();

    }

    public function index() {
        $data['albums'] = $this->photos_model->get_albums();
        $data['photos'] = $this->photos_model->get_album();

        $this->load->view('header',$data);
        $this->load->view('photos/all');
        $this->load->view('footer');
    }

    public function album($id = 0) {
        if((int)$id != 0) {
            $data['photos'] = $this->photos_model->get_album((int)$id);
            $this->load->view('header',$data);
            $this->load->view('photos/album');
            $this->load->view('footer');
        }
    }

    public function create_album() {
        $this->form_validation->set_rules('name', 'Имя', 'required');
        if (!$this->form_validation->run() == FALSE) {
            $this->photos_model->create_album($this->input->post('name'), $this->input->post('description'));
        }
        redirect('/photos');
    }

    public function add_photo() {
        $this->photos_model->add_photo();
        redirect('photos');
    }

    public function add_avatar() {
        $album_id = $this->photos_model->get_profile_album($this->user->id);
        $new_avatar = $this->photos_model->add_photo($album_id);
        $this->photos_model->update_avatar($new_avatar);
        redirect('profile');

    }
}
