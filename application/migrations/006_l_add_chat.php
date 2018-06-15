<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_chat extends CI_Migration {

    public function up() {
        // Table structure for table 'chat'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'from' => array('type' => 'INT'),
            'to' => array('type' => 'INT'),
            'date_create' => array('type' => 'TIMESTAMP'),
        ));
        $this->dbforge->create_table('chat');

        $sql = 'ALTER TABLE `chat` 
                CHANGE `date_create` `date_create` TIMESTAMP on update CURRENT_TIMESTAMP 
                NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->db->query($sql);

        // Table structure for table 'chat_message'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'chat_id' => array('type' => 'INT'),
            'user_id' => array('type' => 'INT'),
            'date_add' => array('type' => 'TIMESTAMP'),
            'status' => array('type' => 'INT', 'default' => 0),
            'content' => array('type' => 'TEXT', 'null' => TRUE),
        ));
        $this->dbforge->create_table('chat_message');

        $sql1 = 'ALTER TABLE `chat_message` 
                 CHANGE `date_add` `date_add` TIMESTAMP on update CURRENT_TIMESTAMP 
                 NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->db->query($sql1);
    }

    public function down() {

    }
}
