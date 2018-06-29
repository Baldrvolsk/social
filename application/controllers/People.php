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
        $data['people'] = $this->get_people();
        $data['on_people'] = $this->get_people(10, 0, true);

        $this->load->view('header', $data);
        $this->load->view('people/index');
        $this->load->view('footer');
    }

    public function get_people($limit = 10, $offset = 0, $online = false) {
        $where["users.id !="] = $this->user->id;
        if ($online) $where['users_meta.online'] = true;
        return $this->db
            ->select('users.id as id,
                 concat(users.first_name," ",users.last_name) as full_name_user,
                 users.company as photo,
                 f_u.friend_status as f_u_status,
                 u_f.friend_status as u_f_status,
                 users_meta.online as online')
            ->from('users')
            ->join('friends as f_u',
                   '(f_u.user_id = users.id AND f_u.friend_id = '.$this->user->id.')',
                    'left')
            ->join('friends as u_f',
                   '(u_f.user_id = '.$this->user->id.' AND u_f.friend_id = users.id)',
                   'left')
            ->join('users_meta',
                   'users_meta.id = users.id',
                   'left')
            ->where($where)
            ->limit($limit, $offset)
            ->get()->result();
    }

}