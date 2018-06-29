<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_friends_users_meta extends CI_Migration {

	public function up() {

        $fields = array(
            'online' => array(
                'type' => "BOOLEAN",
                'default' => 0,
                'after' => 'id'
            )
        );
        $this->dbforge->add_column('users_meta', $fields);
	}

	public function down() {

	}
}
