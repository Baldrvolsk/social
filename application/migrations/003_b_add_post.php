<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_b_add_post extends CI_Migration {

	public function up() {
        // Table structure for table 'post'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'date_edit' => array('type' => 'TIMESTAMP'),
            'content' => array('type' => 'TEXT', 'null' => TRUE),
            'link' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'views' => array('type' => 'INT'),
            'like' => array('type' => 'INT'),
            'dislike' => array('type' => 'INT'),
            'comments' => array('type' => 'INT'),
            'repost' => array('type' => 'INT'),
            'no_comm' => array('type' => 'BOOLEAN', 'default' => false),
        ));
        $this->dbforge->create_table('post');

        // Table structure for table 'post_comment'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'post_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'date_edit' => array('type' => 'TIMESTAMP'),
            'content' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'like' => array('type' => 'INT'),
            'dislike' => array('type' => 'INT'),
        ));
        $this->dbforge->create_table('post_comment');

	}

	public function down() {

	}
}
