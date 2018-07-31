<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_group_post extends CI_Migration {

	public function up() {
        // Table structure for table 'post'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'group_id' => array('type' => 'INT'),
            'user_create_id' => array('type' => 'INT'),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
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
        $this->dbforge->create_table('community_post');

        // Table structure for table 'community_post_comment'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'post_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'content' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'like' => array('type' => 'INT'),
            'dislike' => array('type' => 'INT'),
        ));
        $this->dbforge->create_table('community_post_comment');

        // Table structure for table 'community_post_like'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'post_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'like' => array('type' => 'BOOLEAN'),
        ));
        $this->dbforge->create_table('community_post_like');
	}

	public function down() {

	}
}
