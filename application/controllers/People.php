<?php

class People extends CI_Controller
{
    public $user;
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $data['people'] = $this->ion_auth
            ->select('id, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo')
            ->limit(10)
            ->users()->result();
        $data['on_people'] = $this->ion_auth
            ->select('id, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo')
            ->limit(10)
            ->users()->result();
        //echo '<pre>'.var_dump($data).'</pre>';die();
        $this->load->view('header', $data);
        $this->load->view('people/index');
        $this->load->view('footer');
    }

}