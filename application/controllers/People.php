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
            ->load('user/people', $data);
    }

    public function get_people($limit = 10, $offset = 0, $online = false) {
        $where["user.id !="] = $this->user->id;
        if ($online) $where['user_meta.online'] = true;
        return $this->db
            ->select('user.id as id,
                 concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar,
                 f_u.friend_status as f_u_status,
                 u_f.friend_status as u_f_status,
                 user_meta.online as online')
            ->from('user')
            ->join('friend as f_u',
                   '(f_u.user_id = user.id AND f_u.friend_id = '.$this->user->id.')',
                    'left')
            ->join('friend as u_f',
                   '(u_f.user_id = '.$this->user->id.' AND u_f.friend_id = user.id)',
                   'left')
            ->join('user_meta',
                   'user_meta.id = user.id',
                   'left')
            ->where($where)
            ->limit($limit, $offset)
            ->get()->result();
    }

}