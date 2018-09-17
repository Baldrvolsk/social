<?php

class People_model extends CI_Model
{
    public function __construct() { }

    public function get_people($user_id, $limit = 40, $offset = 0) {
        $where["user.id !="] = $user_id;
        return $this->db
            ->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
            ->from('user')
            ->join('friend as f_u',
                   '(f_u.user_id = user.id AND f_u.friend_id = '.$this->user->id.')',
                   'left')
            ->join('friend as u_f',
                   '(u_f.user_id = '.$this->user->id.' AND u_f.friend_id = user.id)',
                   'left')
            ->join('user_group as u_g',
                   'u_g.user_id = user.id',
                   'left')
            ->join('user_meta',
                   'user_meta.id = user.id',
                   'left')
            ->where($where)
            ->limit($limit, $offset)
            ->get()->result();
    }
}