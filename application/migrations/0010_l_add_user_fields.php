<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_user_fields extends CI_Migration {

    public function up() {
      $this->db->query('ALTER TABLE `users` ADD `gender` VARCHAR(10) NOT NULL AFTER `country`');
      $this->db->query('ALTER TABLE `users` CHANGE `country` `country` VARCHAR(10) NULL DEFAULT NULL;');
    }

    public function down() {

    }
}
