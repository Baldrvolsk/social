<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_users_meta extends CI_Migration {

	public function up() {
        // Table structure for table 'users_meta'
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT'),
            'count_day_like' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'all_like' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'all_dislike' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'max_delta' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'leptas' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'max_leptas' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
        ));
        $this->dbforge->create_table('users_meta');
	}

	public function down() {

	}
}
