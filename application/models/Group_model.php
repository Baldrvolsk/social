<?php


class Group_model extends CI_Model
{
    private $com_table = 'community';
    private $com_group_table = 'community_groups';
    private $com_users_table = 'community_users';

    public function __construct() {
        $this->load->helper('array_helper');
        $this->load->model('like_model');
        $this->like_model->set_type('community');
    }

    public function add_new_group($data, $owner_id) {
        $this->db->insert($this->com_table, $data);
        $u_data['user_id'] = $owner_id;
        $u_data['community_id'] = $this->db->insert_id();
        $u_data['community_group_id'] = 50;
        $this->db->insert($this->com_users_table, $u_data);
    }

    public function follow_group($user_id, $group_id) {
        $data['user_id'] = $user_id;
        $data['community_id'] = $group_id;
        $data['community_group_id'] = 10;
        if ($this->db->insert($this->com_users_table, $data)) {
            return 'Вы вступили в группу';
        } else {
            return 'Что-то пошло не так';
        }
    }

    public function get_all_groups($limit = 10, $offset = 0) {
        return $this->db->select('com.id, com.name, com.slogan, com.label, COUNT(c_u.user_id) as count_users')
            ->from($this->com_table.' as com')
            ->join($this->com_users_table.' as c_u',
                   'c_u.community_id = com.id',
                   'left')
            ->order_by('com.create_date', 'DESC')
            ->limit($limit, $offset)
            ->group_by('com.id')
            ->get()->result();
    }

    public function get_my_groups($user_id, $limit = 10, $offset = 0) {
        return $this->db->select('com.id, com.name, com.slogan, com.label, COUNT(cc_u.user_id) as count_users')
            ->from($this->com_users_table.' as c_u')
            ->join($this->com_table.' as com',
                   'com.id = c_u.community_id',
                   'left')
            ->join($this->com_users_table.' as cc_u',
                   'cc_u.community_id = com.id',
                   'left')
            ->where('c_u.user_id', $user_id)
            ->order_by('com.create_date', 'DESC')
            ->limit($limit, $offset)
            ->group_by('com.id')
            ->get()->result();
    }

    /*
     * public function get_group_list($filter = array(), $user_id, $lang = 'en') {
        $where = 'fr.friend_id = '.$user_id.' AND fr.friend_status = \'request\'';
        return $this->db->select('com.*, c_u.*')
            ->from($this->com_table.' as com')
            ->join($this->com_users_table.' as c_u',
                   'c_u.community_id = com.id AND c_u.community_group_id >= 20',
                   'left')
            ->join('users as u',
                   'u.id = fr.user_id',
                   'left')
            ->join('users_meta as um',
                   'um.id = fr.user_id',
                   'left')
            ->where($where)->get()->result();
    }
     */
}