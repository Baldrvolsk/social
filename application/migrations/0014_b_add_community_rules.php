<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_community_rules extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'community_id' => array('type' => 'INT'),
            'community_group_id' => array('type' => 'INT'),
            'rules' => array('type' => 'JSON')
        ));
        $this->dbforge->create_table('community_rules');
    }

    public function down() {

    }
}
