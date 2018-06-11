<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 11.06.2018
 * Time: 0:09
 */

class Migrate extends CI_Controller
{

    public function index() {
        $this->load->library('migration');

        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            redirect('profile', 'refresh');
        }
    }

}