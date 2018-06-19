<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_photos extends CI_Migration {

    public function up() {
        $this->db->query('CREATE TABLE `albums` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `name` VARCHAR(255) NOT NULL , `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `status` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
        $this->db->query('CREATE TABLE `photos` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `album_id` INT NOT NULL , `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `description` LONGTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
    }

    public function down() {

    }
}
