<?php

class People extends CI_Controller
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
        $data['people'] = $this->friend_model->get_people($this->user->id);
        $debug = array();
        if (DEBUG) {
            $debug['debug'][] = array(
                't' => 'Данные',
                'c' => pretty_print($data)
            );
            $debug['debug'][] = array(
                't' => '$_SESSION',
                'c' => pretty_print($_SESSION)
            );
        }
        $this->theme
            ->title('Люди')
            ->add_partial('header')
            ->add_partial('l_sidebar')
            ->add_partial('r_sidebar')
            ->add_partial('footer', $debug)
            ->load('user/people', $data);
    }

    public function get_lazy() {
        $startFrom = $this->input->post('startFrom');
        // Получаем 30 пользователей, начиная с последнего отображенного
        $people = $this->friend_model->get_people($this->user->id, 30, $startFrom);
        $ret = array();
        foreach ($people as $row) {
            $ret[] = $this->theme->view('user/people_item', array('row' => $row, 'full' => true), true);
        }
        echo json_encode($ret);
    }
}