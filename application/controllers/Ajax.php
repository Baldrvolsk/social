<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public $user;

    public function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in())
        {
            #redirect('profile');
            die('access denied');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {

    }

    public function save_status() {
        $this->db->where('id',$this->user->id);
        $this->db->set('text_status', $this->input->post('status'));
        $this->db->update('users');
    }
}
