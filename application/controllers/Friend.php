<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 12.06.2018
 * Time: 12:49
 */

class Friend extends CI_Controller
{
    public $user;
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('', 'refresh');
        } else {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->model('friend_model');
        $this->lang->load('profile');
    }

    public function index() {
        $data['friends'] = $this->friend_model->get_friends($this->user->id);
        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Данные',
                'c' => pretty_print($data)
            );
        }
        $this->theme
            ->title('Друзья')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('user/friend', $data);
    }

    public function get_friend_list() {
        if ($this->form_validation->run('getFriendList') === FALSE) { //Если валидация не прошла
            $ret['status'] = "ERR";
            $ret['type_err'] = $this->form_validation->error('type');
            $ret['message'] = 'Что-то пошло не так, попробуйте позже';
            if (DEBUG) $ret['error'] = 'не прошла валидация';
        } else {
            $type = $this->input->post('type');
            $data = array();
            switch ($type) {
                case 'friend':
                    $data = $this->friend_model->get_friends($this->user->id);
                    break;
                case 'confirm':
                    $data = $this->friend_model->get_friends_request($this->user->id);
                    break;
                case 'request':
                    $data = $this->friend_model->get_user_request($this->user->id);
                    break;
                case 'subscriber':
                    $data = $this->friend_model->get_user_subscriber($this->user->id);
                    break;
                case 'blacklist':
                    $data = $this->friend_model->get_blacklist($this->user->id);
                    break;
            }
            $ret['status'] = "OK";
            $ret['html'] = $this->theme->view('user/friend_list', array('friends' => $data), true);
        }
        echo json_encode($ret);
    }

    public function change_status() {
        if ($this->form_validation->run('friendChangeStatus') === FALSE) { //Если валидация не прошла
            $ret['status'] = "ERR";
            $ret['id_err'] = $this->form_validation->error('id');
            $ret['status_err'] = $this->form_validation->error('status');
            $ret['message'] = 'Что-то пошло не так, попробуйте позже';
            if (DEBUG) $ret['error'] = 'не прошла валидация';
        } else {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $ret = $this->friend_model->change_friend_status($this->user->id, $id, $status);
        }
        echo json_encode($ret);
    }
}