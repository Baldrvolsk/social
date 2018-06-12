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
    public function __construct() {

    }

    public function get_post($id = null) {
        if ($id === null) {
            $query = $this->db->get($this->post_table);
            return $query->result_array();
        }

        $query = $this->db->get_where($this->post_table, array('id' => $id));
        return $query->row_array();
    }
    public function get_users_post($user_id = null, $limit = null, $offset = null) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');
        if ($limit !== null && $limit !== 0) {
            if ($offset === null) $offset = 0;
            $this->db->join('users', 'users.id = post.user_id');
            $this->db->order_by($this->post_table.'.date_add', 'desc');
            $this->db->where($this->post_table.'.user_id', $user_id);
            $query = $this->db->get($this->post_table, $limit, $offset);
            return $query->result_array();
        }
    }

    public function createPost() {
        $content = $this->input->post('content', true);
        //$this->load->helper('url');

        $link = null;
        $tags = null;
        $data = array(
            'user_id' => $this->input->post('userId'),
            'date_add' => mdate('%Y-%m-%d %H:%i:%s', now()),
            'date_edit' => mdate('%Y-%m-%d %H:%i:%s', now()),
            'content' => $content,
            'link' => $link,
            'tags' => $tags,
            'views' => 0,
            'like' => 0,
            'dislike' => 0,
            'comments' => 0,
            'repost' => 0,
            'no_comm' => 0,
        );

        return $this->db->insert('post', $data);
    }

}