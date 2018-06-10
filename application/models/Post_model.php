<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Post_model extends CI_Model
{
    private $post_table = 'post';
    private $comm_table = 'post_comment';
    public function __construct() {}

    public function get_post($id = null) {
        if ($id === null) {
            $query = $this->db->get($this->post_table);
            return $query->result_array();
        }

        $query = $this->db->get_where($this->post_table, array('id' => $id));
        return $query->row_array();
    }
    public function get_users_post($user_id = null, $limit = null) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');
        if ($limit !== null && $limit !== 0) {
            $this->db->limit($limit);
            $this->db->order_by($this->post_table.'.date_add', 'desc');
            $this->db->where($this->post_table.'.user_id', $user_id);
            $query = $this->db->get($this->post_table);
            return $query->result_array();
        }
    }

    public function createPost() {

    }

}