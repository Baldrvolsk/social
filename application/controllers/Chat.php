<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    public $user;
    public function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
        $this->user = $this->ion_auth->user()->row();
        $this->load->model('chat_model');
    }

    public function index($id = 0) {
        if((int)$id != 0) {
            if($this->chat_model->check_user_chat($id))
            {
                $data['chat'] = $this->chat_model->get_chat((int)$id);
                $data['chat_id'] = $id;
                $this->load->view('header',$data);
                $this->load->view('chat/show_chat');
                $this->load->view('footer');
            } else {
                die('Это не твой чат');
            }
        } else {
            $data['chats'] = $this->chat_model->get_user_chats();
            $this->load->view('header',$data);
            $this->load->view('chat/chat');
            $this->load->view('footer');
        }
    }

    public function send() {
        if($chat_id = $this->input->post('chat_id'))
        {
            if($this->chat_model->check_user_chat($chat_id))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('content', 'Текст', 'trim|required');
                $this->form_validation->set_rules('chat_id', 'Номер чата', 'required');
                if ($this->form_validation->run()) {
                    $this->chat_model->add_message();
                }
            } else {
                die('хакер чтоли?');
            }
        } else {

            $this->chat_model->find_chat((int)$this->input->post('user_id'));
        }
        redirect('/chat/index/'.$this->input->post('chat_id'));
    }

}
