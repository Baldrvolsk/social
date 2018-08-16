<?php

class Page_model extends CI_Model
{
    private $page_table = 'static_page';

    public function __construct() { }

    public function get_page($page_id) {
        if (is_int($page_id)) {
            $this->db->where('id', $page_id, true);
        } elseif (is_string($page_id)) {
            $this->db->where('name', $page_id, true);
        } else {
            return false;
        }
        return $this->db->from($this->page_table)
            ->limit(1)
            ->get()->row();
    }
}