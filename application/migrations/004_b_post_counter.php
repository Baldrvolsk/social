<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_post_counter extends CI_Migration {

	public function up() {
        // Change table structure 'post'
        $fields = array(
            'user_create_id' => array('type' => 'INT', 'after' => 'user_id')
        );
        $this->dbforge->add_column('post', $fields);

        // Table structure for table 'post_like'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'post_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'like' => array('type' => 'BOOLEAN'),
        ));
        $this->dbforge->create_table('post_like');

	}

	public function down() {

	}
}
