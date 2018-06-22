<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 12.06.2018
 * Time: 12:49
 */

class Friends extends CI_Controller
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
        $data['friends'] = $this->friend_model->get_friends($this->user->id, 'confirmed');
        $data['req_friends'] = $this->friend_model->get_friends($this->user->id, 'request');
        //echo '<pre>'.var_dump($data).'</pre>';die();
        $this->load->view('header', $data);
        $this->load->view('friend/index');
        $this->load->view('footer');
    }

    public function add_friend($id, $group_id) {
        $this->friend_model->add_friend($this->user->id, $id, $group_id);
        redirect('friends', 'refresh');
    }

    public function confirm_friend($id) {
        $this->friend_model->change_friend_status($this->user->id, (int)$id, 'confirmed');
    }

    public function delete_friend($id) {
        $this->friend_model->delete_friend($this->user->id, $id);
        redirect('friends', 'refresh');
    }
}