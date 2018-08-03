<?php


class Group_model extends CI_Model
{
    private $com_table = 'community';
    private $com_group_table = 'community_groups';
    private $com_users_table = 'community_users';
    private $com_rules = 'community_rules';

    public function __construct() {
        $this->load->helper('array_helper');
        $this->load->model('like_model');
        $this->like_model->set_type('community');
    }

    public function add_new_group($data, $owner_id) {
        if ($this->db->insert($this->com_table, $data)) {
            $ret = true;
            $u_data['user_id'] = $owner_id;
            $u_data['community_id'] = $this->db->insert_id();
            $u_data['community_group_id'] = 50;
            $u_data['contacts'] = 1;
            if (!$this->db->insert($this->com_users_table, $u_data)) $ret = false;
            $set = array('last_group_create' => $data['create_date']);
            $this->ion_auth->set_meta($owner_id, $set);
        } else $ret = false;
        return $ret;
    }

    public function update_group($data, $group_id) {
        $this->db->where('id', $group_id);
        return $this->db->update($this->com_table, $data);
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

    public function get_group($group_id) {
        $group = $this->db->select('com.*')
            ->from($this->com_table.' as com')
            ->limit(1)
            ->where('com.id', $group_id)
            ->get()->row();
        $group->setting = json_decode($group->setting);
        $group->rules = json_decode($group->rules);
        $g_u = $this->db->select('COUNT(user_id) as count')
            ->from($this->com_users_table)
            ->where('community_id', $group_id)
            ->get()->row();
        $group->count_users = $g_u->count;
        return $group;
    }

    public function get_contacts($group_id) {
        $group = $this->db->select('c_u.*, 
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.company as photo, c_g.*')
            ->from($this->com_users_table.' as c_u')
            ->join('users as u',
                'u.id = c_u.user_id',
                'left')
            ->join($this->com_group_table.' as c_g',
                   'c_g.id = c_u.community_group_id',
                   'left')
            ->where('c_u.community_id', $group_id)
            ->where('c_u.contacts', 1)
            ->get()->result();
        return $group;
    }

    public function get_user_com_gr_id($user_id, $com_id) {
        $ret = $this->db->select('community_group_id')
            ->from($this->com_users_table)
            ->where(array('user_id' => $user_id, 'community_id' => $com_id))
            ->get()->row();
        return (empty($ret))?null:(int)$ret->community_group_id;
    }

    public function check_group($id) {
        $check = $this->db->get_where($this->com_table, 'id = '.$id, 1);
        return (empty($check))?false:true;
    }

}