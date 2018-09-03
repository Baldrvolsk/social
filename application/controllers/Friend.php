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
        $this->load->model('friend_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $data['friends'] = $this->friend_model->get_friends($this->user->id);
        $data['on_friends'] = $this->friend_model->get_friends($this->user->id, true);
        $data['req_friends'] = $this->friend_model->get_friends_request($this->user->id);
        $data['user_request'] = $this->friend_model->get_user_request($this->user->id);
        $data['blacklist'] = $this->friend_model->get_blacklist($this->user->id);

        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Данные',
                'c' => var_debug($data)
            );
        }
        $this->theme
            ->title('Люди')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('user/friend', $data);
    }

    public function add_friend($id, $group_id) {
        $this->friend_model->add_friend($this->user->id, $id, $group_id);
        redirect('friend', 'refresh');
    }

    public function confirm_friend($id) {
        $this->friend_model->change_friend_status((int)$id, $this->user->id, 'confirmed');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_friend($id) {
        $this->friend_model->delete_friend($this->user->id, $id);
        redirect('friend', 'refresh');
    }
}