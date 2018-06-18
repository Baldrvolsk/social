<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:04
 */

class Like_model extends CI_Model
{
    private $type;
    private $like_table;

    public function __construct() { }

    public function set_type($type) {
        $this->type = $type;
        $this->like_table = $type.'_like';
    }

    public function get_like($type_id = null, $user_id = null) {
        if ($type_id === null || $user_id === null) {
            return null;
        }
        $this->db->select('id');
        $where = array(
            $this->type.'_id' => $type_id,
            'user_id' => $user_id,
        );
        $query = $this->db->get_where($this->like_table, $where);
        return $query->row();
    }

    public function set_like($type_id = null, $user_id = null, $type = null) {
        if ($type_id === null || $user_id === null || $type === null) {
            return;
        }
        $id = $this->get_like($type_id, $user_id);

        if ($id->id) {
            $this->db->set('like', $type);
            $this->db->where('id', $id->id);
            $this->db->update($this->like_table);
        } else {
            $data = array(
                $this->type.'_id' => $type_id,
                'user_id' => $user_id,
                'like' => $type,
            );
            return $this->db->insert($this->like_table, $data);
        }
    }

}