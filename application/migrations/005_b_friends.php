<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_friends extends CI_Migration {

	public function up() {
        // Table structure for table 'friends'
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'INT'),
            'friend_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'friend_group_id' => array('type' => 'INT', 'default' => 0),
        ));
        $this->dbforge->create_table('friends');

        // Table structure for table 'friend_group'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'INT'),
            'name' => array('type' => 'VARCHAR', 'constraint' => '50'),
        ));
        $this->dbforge->create_table('friend_group');
	}

	public function down() {

	}
}
