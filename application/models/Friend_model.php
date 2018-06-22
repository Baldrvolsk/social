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

    public function get_friends($user_id = null, $status, $fr_group = null) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');
        $where = array(
            $this->friend_table.'.friend_status' => $status,
        );
        if ($status === 'request') {
            $where[$this->friend_table.'.friend_id'] = $user_id;
        } else {
            $where[$this->friend_table.'.user_id'] = $user_id;
        }
        if ($fr_group !== null) {
            $where[$this->friend_table.'.friend_group_id'] = $user_id;
            $this->db->join($this->fr_group_table, $this->fr_group_table.'.id = '.$this->friend_table.'.friend_group_id');
        }
        $this->db->select($this->friend_table.'.*, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo')
            ->join('users', 'users.id = '.$this->friend_table.'.friend_id')
            ->where($where)
            ->order_by($this->friend_table.'.date_add', 'desc');
        //echo $this->db->get_compiled_select();die();
        return $this->db->get($this->friend_table)->result();
    }

    public function add_friend($user_id, $friend_id, $friend_group_id = null) {
        $data = array(
            'user_id' => $user_id,
            'friend_id' => $friend_id,
            'date_add' => mdate('%Y-%m-%d %H:%i:%s', now()),
            'friend_group_id' => $friend_group_id,
        );

        return $this->db->insert($this->friend_table, $data);

    }

    public function change_friend_status($user_id, $friend_id, $status) {
        $this->db->set('friend_status', $status);
        $this->db->where(array('user_id' => $user_id, 'friend_id' => $friend_id));
        $this->db->update($this->friend_table);
    }

    public function delete_friend($user_id, $friend_id) {
        return $this->db->delete($this->friend_table, array('user_id' => $user_id, 'friend_id' => $friend_id));
    }
}