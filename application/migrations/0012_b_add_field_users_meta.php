<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_users_meta extends CI_Migration {

    public function up() {
        $fields = array('last_group_create' => array('type' => 'TIMESTAMP'));
        $this->dbforge->add_column('users_meta', $fields);
    }

    public function down() {

    }
}
