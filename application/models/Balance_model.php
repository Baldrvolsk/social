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
            return null;
        }
        return $this->db->get_where($this->comm_table, array('id' => (int)$id))->row();
    }

    public function get_comments($id = null, $limit = null, $offset = null) {
        if ($id === null) {
            return null;
        }
        if ($limit !== null && $limit !== 0) {
            if ($offset === null) $offset = 0;
            $this->db->limit($limit, $offset);
        }
        $this->db->select($this->comm_table.'.*, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo')
                 ->from($this->comm_table)
                 ->join('users', 'users.id = '.$this->comm_table.'.user_id', 'left')
                 ->order_by($this->comm_table.'.date_add', 'desc')
                 ->where($this->comm_table.'.'.$this->type.'_id', $id);
        return $this->db->get()->result();
    }

    public function create_comment($id) {
        $content = $this->input->post('content', true);

        $this->db->set('comments', 'comments+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->type);

        $link = null;
        $tags = null;
        $data = array(
            $this->type.'_id' => $id,
            'user_id' => $this->input->post('userAddId'),
            'content' => $content,
            'tags' => $tags,
            'like' => 0,
            'dislike' => 0,
        );
        return $this->db->insert($this->comm_table, $data);

    }
}