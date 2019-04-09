<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo extends CI_Controller
{
    private $user;
    private $type;
    private $owner_id;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->model('photo_model');
    }

    public function index($type, $id = null) {
        $owner_id = (empty($id))?$this->user->id:$id;
        $this->photo_model->init($type, $owner_id);
        $data['albums'] = $this->photo_model->get_albums();
        $data['photos'] = $this->photo_model->get_ll_photo();

        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Информация о пользователе',
                'c' => pretty_print($data)
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

    public function user($id = null) {
        $this->index('user', $id);
    }

    public function group($id = null) {
        $this->index('group', $id);
    }

    public function event($id = null) {

    }

    public function init($type, $id) {
        $this->type = $type;
        $this->owner_id = $id;
        $this->photo_model->init($this->type, $this->owner_id);
    }

    public function album($id = 0) {
        if ((int)$id != 0) {
            $data['Photo'] = $this->photo_model->get_album((int)$id);
            $debug = array();
            if (DEBUG) {
                $debug['debug'][] = array(
                    't' => 'Информация о пользователе',
                    'c' => pretty_print($data)
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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Имя', 'required');
        if (!$this->form_validation->run() == FALSE) {
            $this->photo_model->create_album($this->input->post('name'), $this->input->post('description'));
        }
        redirect('/photos');
    }

    public function add_photo() {
        $this->photo_model->add_photo();
        //redirect('photo');
    }

    public function add_avatar() {
        /*$album_id = $this->photo_model->get_profile_album($this->user->id);
        $new_avatar = $this->photo_model->add_photo($album_id);
        $this->photo_model->update_avatar($new_avatar);*/
    }
}
