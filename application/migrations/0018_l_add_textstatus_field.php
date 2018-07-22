<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_textstatus_field extends CI_Migration {

    public function up() {
        $this->db->query('ALTER TABLE `users`  ADD `text_status` VARCHAR(255) NOT NULL  AFTER `gender`');
        $this->db->query('ALTER TABLE `users` ADD `birth` DATE NULL DEFAULT NULL AFTER `gender`');

    }

    public function down() {

    }
}
