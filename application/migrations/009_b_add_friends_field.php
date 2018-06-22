<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_friends_field extends CI_Migration {

	public function up() {

        $fields = array(
            'friend_status' => array(
                'type' => "SET('request','confirmed','subscriber','blacklist')",
                'default' => 'request',
                'after' => 'friend_id'
            )
        );
        $this->dbforge->add_column('friends', $fields);
	}

	public function down() {

	}
}
