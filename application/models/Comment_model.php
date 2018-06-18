<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:04
 */

class Comment_model extends CI_Model
{
    private $type;
    private $comm_table;

    public function __construct() { }

    public function set_type($type) {
        $this->type = $type;
        $this->comm_table = $type.'_comment';
    }

    public function get_comment($id = null) {
        if ($id === null) {
            return;
        }

        $query = $this->db->get_where($this->comm_table, array('id' => $id));
        return $query->row();
    }

    public function get_comments($id = null, $limit = null, $offset = null) {
        if ($id === null) {
            return;
        }
        if ($limit !== null && $limit !== 0) {
            if ($offset === null) $offset = 0;
            $this->db->limit($limit, $offset);
        }
        $this->db->join('users', 'users.id = '.$this->comm_table.'.user_id', 'left');
        $this->db->order_by($this->comm_table.'.date_add', 'desc');
        $this->db->where($this->comm_table.'.'.$this->type.'_id', $id);
        $query = $this->db->get($this->comm_table);
        $ret = $query->result();

        return $ret;
    }

    public function createComments($id) {
        $content = $this->input->post('content', true);
        //$this->load->helper('url');

        $this->db->set('comments', 'comments+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->type);

        $link = null;
        $tags = null;
        $data = array(
            $this->type.'_id' => $id,
            'user_id' => $this->input->post('userAddId'),
            'content' => $content,
            'link' => $link,
            'tags' => $tags,
            'views' => 0,
            'like' => 0,
            'dislike' => 0,
        );
        return $this->db->insert($this->comm_table, $data);

    }
}