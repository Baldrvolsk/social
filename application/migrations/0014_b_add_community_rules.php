<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_community_rules extends CI_Migration {

    public function up() {
        $fields = array(
            'rules' => array('type' => 'JSON')
        );
        $this->dbforge->add_column('community', $fields);
    }

    public function down() {

    }
}
