<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo extends CI_Controller
{
    private $user;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->model('photo_model');
        $this->photo_model->init('user', $this->user->id);
        $this->load->library('form_validation');
    }

    public function index() {
        $data['albums'] = $this->photo_model->get_albums();
        $data['photo'] = $this->photo_model->get_album();

        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Информация о пользователе',
                'c' => var_debug($data)
            );
        }
        $this->theme
            ->title('Фото')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('photo/list', $data);
    }

    public function init($id) {
        $this->photo_model->init('user', $id);
    }
    public function album($id = 0) {
        if ((int)$id != 0) {
            $data['Photo'] = $this->photos_model->get_album((int)$id);
            $debug = array();
            if (DEBUG) {
                $debug['debug'][] = array(
                    't' => 'Информация о пользователе',
                    'c' => var_debug($data)
                );
            }
            $this->theme
                ->title('Фото')
                ->add_partial('header')
                ->add_partial('l_sidebar')
                ->add_partial('r_sidebar')
                ->add_partial('footer', $debug)
                ->load('photo/album', $data);
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
        redirect('Photo');
    }

    public function add_avatar() {
        $album_id = $this->photos_model->get_profile_album($this->user->id);
        $new_avatar = $this->photos_model->add_photo($album_id);
        $this->photos_model->update_avatar($new_avatar);
        redirect('profile');

    }
}
