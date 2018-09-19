<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 11.06.2018
 * Time: 0:09
 */

class Migrate extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            redirect('', 'refresh');
        }
    }

    public function index() {
        $this->load->library('migration');
        $v = $this->migration->latest();
        if ($v === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Migrate to version '.$v.' complete <a href="'.site_url('/').'">goto site &raquo;</a>';
        }
    }
    
}