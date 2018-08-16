<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_page_table extends CI_Migration {

	public function up() {
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'name' => array('type' => 'VARCHAR', 'constraint' => 128),
            '`last_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'head' => array('type' => 'VARCHAR', 'constraint' => 128),
            'title' => array('type' => 'TEXT'),
            'descr' => array('type' => 'TEXT'),
            'keywords' => array('type' => 'TEXT'),
            'content' => array('type' => 'TEXT'),
        ));
        $this->dbforge->create_table('static_page');
	}

	public function down() {

	}
}
