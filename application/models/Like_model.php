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
        $where = array(
            $this->type.'_id' => $type_id,
            'user_id' => $user_id,
        );
        $this->db->from($this->like_table)
            ->where($where)
            ->limit(1);
        return $this->db->get()->row();
    }

    public function set_like($type_id = null, $user_id = null, $type = null) {
        if ($type_id === null || $user_id === null || $type === null) {
            return;
        }
        $id = $this->get_like($type_id, $user_id);
        if (!empty($id)) {
            $this->db->set('like', $type);
            $this->db->set('date_add', mdate('%Y-%m-%d %H:%i:%s', now()));
            $this->db->where('id', $id->id);
            $this->db->update($this->like_table);
        } else {
            $data = array(
                $this->type.'_id' => $type_id,
                'user_id' => $user_id,
                'date_add' => mdate('%Y-%m-%d %H:%i:%s', now()),
                'like' => $type,
            );
            return $this->db->insert($this->like_table, $data);
        }
    }

}