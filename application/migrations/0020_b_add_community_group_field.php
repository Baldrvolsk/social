<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_community_group_field extends CI_Migration {

	public function up() {
        $fields = array(
            'type' => array('type' => 'VARCHAR', 'constraint' => '20')
        );
        $this->dbforge->add_column('community_groups', $fields);

        $this->db->update('community_groups', array('type' => 'o'), array('id' => '50'));
        $this->db->update('community_groups', array('type' => 'a'), array('id' => '40'));
        $this->db->update('community_groups', array('type' => 'e'), array('id' => '30'));
        $this->db->update('community_groups', array('type' => 'm'), array('id' => '20'));
        $this->db->update('community_groups', array('type' => 'u'), array('id' => '10'));

	}

	public function down() {

	}
}
