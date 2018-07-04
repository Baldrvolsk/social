<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_groups extends CI_Migration {

    public function up() {
        // Structure for table 'community'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'name' => array('type' => 'VARCHAR', 'constraint' => 128),
            'create_date' => array('type' => 'TIMESTAMP'),
            'slogan' => array('type' => 'VARCHAR', 'constraint' => 512),
            'description' => array('type' => 'TEXT'),
            'group_dir' => array('type' => 'TEXT'),
            'label' => array('type' => 'TEXT'),
        ));
        $this->dbforge->create_table('community');

        $sql = 'ALTER TABLE `community` 
                CHANGE `create_date` `create_date` TIMESTAMP 
                NOT NULL DEFAULT CURRENT_TIMESTAMP';
        $this->db->query($sql);

        // Structure for table 'community_groups'
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'name_en' => array('type' => 'VARCHAR', 'constraint' => 128),
            'name_ru' => array('type' => 'VARCHAR', 'constraint' => 128),
        ));
        $this->dbforge->create_table('community_groups');

        // Dumping data for table 'community_groups'
        $data = array(
            array('id' => '10', 'name_en' => 'Member', 'name_ru' => 'Участник'),
            array('id' => '20', 'name_en' => 'Moderator', 'name_ru' => 'Модератор'),
            array('id' => '30', 'name_en' => 'Editor', 'name_ru' => 'Редактор'),
            array('id' => '40', 'name_en' => 'Administrator', 'name_ru' => 'Администратор'),
            array('id' => '50', 'name_en' => 'Owner', 'name_ru' => 'Владелец'),
        );
        $this->db->insert_batch('community_groups', $data);

        // Structure for table 'community_users'
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'INT'),
            'community_id' => array('type' => 'INT'),
            'community_group_id' => array('type' => 'INT'),

        ));
        $this->dbforge->create_table('community_users');
        $group_dir = WEBROOT.DS.'uploads'.DS.'group';
        if (!is_dir($group_dir)) {
            mkdir($group_dir, 0755);
        }
    }

    public function down() {

    }
}
