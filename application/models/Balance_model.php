<?php

class Balance_model extends CI_Model
{
    public function __construct() { }

    public function add_balance($user_id, $leptas, $comment) {
        $this->db->trans_start();
        $data = array(
            'user_id' => $user_id,
            'leptas' => $leptas,
            'comments' => $comment,
            'trans_number' => null
        );
        $this->db->insert('buy', $data);
        $u = $this->db->get_where('users_meta', array('id' => $user_id), 1)->row();

        if ($u) {
            $this->db->set('leptas', 'leptas+'.$leptas, FALSE);
            $this->db->where('id', $user_id);
            $this->db->update('users_meta');
        } else {
            $this->db->insert('users_meta', array('id' => $user_id, 'leptas' => $leptas));
        }
        $this->db->trans_complete ();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}