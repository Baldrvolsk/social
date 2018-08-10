<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_group_delete_fields extends CI_Migration {

	public function up() {
        $fields = array(
            'delete_time' => array('type' => 'TIMESTAMP', 'null' => true)
        );
        $this->dbforge->add_column('community', $fields);
	}

	public function down() {

	}
}
