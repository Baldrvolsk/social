<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public $user;

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->model(array('post_model', 'photo_model', 'friend_model', 'group_model'));
        $this->photo_model->init('user');
        $this->post_model->init('user');
        $this->lang->load('profile');
    }

    public function index($id = null) {
        if($id === null) redirect('/profile/'.$this->user->id, 'refresh');
        if ($id === $this->user->id) {
            $userData = $this->user;
        } else {
            $userData = $this->ion_auth->user((int)$id)->row();
        }
        $userData->meta = $this->ion_auth->get_meta($userData->id);
        $userData->group = $this->ion_auth->get_users_groups($userData->id)->result();
        // форматируем данные и получаем данные счетчиков
        $userData->birthDayString = $userData->meta->birth;
        $userData->count = new stdClass();
        $userData->count->friend = 0; //$this->friend_model->count_user_friend($userData->id);
        $userData->count->follower = 0; //$this->friend_model->count_user_follower($userData->id);
        $userData->count->group = 0; //$this->group_model->count_user_group($userData->id);
        $userData->delta = $userData->meta->all_like - $userData->meta->all_dislike;
        // подгружаем фото
        $photoData = $this->photo_model->last_owner_photo($userData->id);
        // подгружаем посты
        $postData = $this->post_model->get_users_post($userData->id);
        $data = array(
            'userData' => $userData,
            'photoData' => $photoData,
            'postAdd' => $this->theme->view('post/add', array('data' => $userData), true),
            'postList' => $this->theme->view('post/list', array('posts' => $postData, 'lang' => $this->router->user_lang), true),

        );
        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Информация о пользователе',
                'c' => var_debug($userData)
            );
            $debug['debug'][] = array(
                't' => 'Posts',
                'c' => var_debug($postData)
            );
        }
        $this->theme
            ->title('Профиль пользователя '.$userData->first_name.' '.$userData->last_name)
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('user/profile', $data);
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
