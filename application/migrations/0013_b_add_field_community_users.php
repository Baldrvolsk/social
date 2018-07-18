<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_community_users extends CI_Migration {

    public function up() {
        $fields = array('contacts' => array('type' => 'BOOLEAN', 'default' => false));
        $this->dbforge->add_column('community_users', $fields);
    }

    public function down() {

    }
}
