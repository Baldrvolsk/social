<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Friend_model extends CI_Model
{
    private $friend_table = 'friends';
    private $fr_group_table = 'friend_group';
    public function __construct() {

    }

    public function get_friends($user_id = null, $fr_group = null) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');
        if ($fr_group !== null) {
            $this->db->where($this->friend_table . '.friend_group_id', $user_id);
            $this->db->join($this->fr_group_table, $this->fr_group_table.'.id = '.$this->friend_table.'.friend_group_id');
        }
        $this->db->join('users', 'users.id = '.$this->friend_table.'.friend_id');
        $this->db->where($this->friend_table.'.user_id', $user_id);
        $this->db->order_by($this->friend_table.'.date_add', 'desc');
        $query = $this->db->get($this->friend_table);
        return $query->result_array();
    }

    public function add_friend($user_id, $friend_id, $friend_group_id = null) {
        $data = array(
            'user_id' => $user_id,
            'friend_id' => $friend_id,
            'date_add' => mdate('%Y-%m-%d %H:%i:%s', now()),
            'friend_group_id' => $friend_group_id,
        );

        return $this->db->insert('post', $data);
    }

}