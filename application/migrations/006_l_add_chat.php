<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_l_add_chat extends CI_Migration {

    public function up() {
        // Table structure for table 'chat'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'from' => array('type' => 'INT'),
            'to' => array('type' => 'INT'),
            'date_create' => array('type' => 'TIMESTAMP', 'default' => 0),
        ));
        $this->dbforge->create_table('chat');

        // Table structure for table 'chat_message'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'chat_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'status' => array('type' => 'INT'),
            'content' => array('type' => 'TEXT', 'null' => TRUE),
        ));
        $this->dbforge->create_table('chat_message');

    }

    public function down() {

    }
}
