<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_balance extends CI_Migration {

    public function up() {
        // Structure for table 'buy'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'INT'),
            'leptas' => array('type' => 'INT', 'unsigned' => TRUE),
            'buy_type' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'admin'),
            'buy_time' => array('type' => 'TIMESTAMP'),
            'type_pay_system' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'admin'),
            'buy_status' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'paid'),
            'comments' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE),
            'pause_until' => array('type' => 'TIMESTAMP'),
            'trans_number' => array('type' => 'INT', 'null' => TRUE),
        ));
        $this->dbforge->create_table('buy');

        $sql = 'ALTER TABLE `buy` 
                CHANGE `buy_time` `buy_time` TIMESTAMP 
                NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->db->query($sql);

        $sql = 'ALTER TABLE `buy` 
                CHANGE `pause_until` `pause_until` TIMESTAMP 
                NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->db->query($sql);
    }

    public function down() {

    }
}
