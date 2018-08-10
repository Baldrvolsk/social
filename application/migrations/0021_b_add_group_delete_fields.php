<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_group_setting extends CI_Migration {

	public function up() {
        $fields = array(
            'setting' => array('type' => 'JSON')
        );
        $this->dbforge->add_column('community', $fields);
	}

	public function down() {

	}
}
