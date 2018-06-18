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
    public function __construct() {
        $this->load->model('like_model', 'like');
        $this->like->set_type('post');
    }

    public function get_post($id = null) {
        if ($id === null) {
            return;
        }

        $query = $this->db->get_where($this->post_table, array('id' => $id));
        return $query->row();
    }
    public function get_users_post($user_id, $limit = null, $offset = null) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');
        if ($limit !== null && $limit !== 0) {
            if ($offset === null) $offset = 0;
            $this->db->limit($limit, $offset);
        }
        $this->db->join('users', 'users.id = post.user_create_id', 'left');
        $this->db->order_by($this->post_table.'.date_add', 'desc');
        $this->db->where($this->post_table.'.user_id', $user_id);
        $query = $this->db->get($this->post_table);
        $ret = $query->result();

        return $ret;
    }

    public function createPost($id) {
        $content = $this->input->post('content', true);
        //$this->load->helper('url');

        $link = null;
        $tags = null;
        $data = array(
            'user_id' => $id,
            'user_create_id' => $this->input->post('userAddId'),
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

    public function like($type, $post_id, $user_id) {

    }

}