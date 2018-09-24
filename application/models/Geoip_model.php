<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Geoip_model - модель для работы с геоданными
 */

class Geoip_model extends CI_Model
{
    private $tables;
    public function __construct() {
        $this->config->load('geoip', TRUE);
        $this->tables = $this->config->item('tables', 'geoip');
        $this->init();
    }

    public function init() {
        log_message('error', 'Init geoip_model');
        $this->load->dbforge();
        if (!$this->db->table_exists($this->tables['continent'])){
            $this->dbforge->add_field(array(
                'id' => array('type' => 'VARCHAR', 'constraint' => '2'),
                'name_en' => array('type' => 'VARCHAR', 'constraint' => '128', 'null' => true),
                'name_ru' => array('type' => 'VARCHAR', 'constraint' => '128', 'null' => true),
            ));
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($this->tables['continent']);

        }
        if (!$this->db->table_exists($this->tables['country'])){
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'unsigned' => true),
                'continent_id' => array('type' => 'VARCHAR', 'constraint' => '2'),
                'country_iso_code' => array('type' => 'VARCHAR', 'constraint' => '2'),
                'name_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'name_ru' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'is_in_european_union' => array('type' => 'TINYINT', 'constraint' => '1', 'unsigned' => true),
            ));
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($this->tables['country']);
            $this->db->query('ALTER TABLE `'.$this->tables['country'].'` ADD INDEX(`country_iso_code`)');
            $this->db->query('ALTER TABLE `'.$this->tables['country'].'` 
                          ADD FOREIGN KEY (`continent_id`) REFERENCES `'.$this->tables['continent'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        }
        if (!$this->db->table_exists($this->tables['region'])){
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'unsigned' => true),
                'country_id' => array('type' => 'INT', 'unsigned' => true),
                'subdivision_1_iso_code' => array('type' => 'VARCHAR', 'constraint' => '3'),
                'subdivision_1_iso_name_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'subdivision_1_iso_name_ru' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'subdivision_2_iso_code' => array('type' => 'VARCHAR', 'constraint' => '3'),
                'subdivision_2_iso_name_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'subdivision_2_iso_name_ru' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
            ));
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($this->tables['region']);
            $this->db->query('ALTER TABLE `'.$this->tables['region'].'` ADD INDEX(`subdivision_1_iso_code`)');
            $this->db->query('ALTER TABLE `'.$this->tables['region'].'` ADD INDEX(`subdivision_2_iso_code`)');
            $this->db->query('ALTER TABLE `'.$this->tables['region'].'` 
                          ADD FOREIGN KEY (`country_id`) REFERENCES `'.$this->tables['country'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        }
        if (!$this->db->table_exists($this->tables['city'])){
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'unsigned' => true),
                'country_id' => array('type' => 'INT', 'unsigned' => true),
                'region_id' => array('type' => 'INT', 'unsigned' => true),
                'city_name_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'city_name_ru' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
            ));
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($this->tables['city']);
            $this->db->query('ALTER TABLE `'.$this->tables['city'].'` ADD INDEX(`country_id`)');
            $this->db->query('ALTER TABLE `'.$this->tables['city'].'` ADD INDEX(`region_id`)');
            $this->db->query('ALTER TABLE `'.$this->tables['city'].'` 
                          ADD FOREIGN KEY (`country_id`) REFERENCES `'.$this->tables['country'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        }
        if (!$this->db->table_exists($this->tables['geoipv4'])){
            $this->dbforge->add_field(array(
                'network' => array('type' => 'VARCHAR', 'constraint' => '20'),
                'geoname_id' => array('type' => 'INT', 'unsigned' => true),
                'latitude' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'longitude' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'accuracy_radius' => array('type' => 'INT', 'unsigned' => true),
            ));
            $this->dbforge->add_key('id');
            $this->dbforge->create_table($this->tables['geoipv4']);
            $this->db->query('ALTER TABLE `'.$this->tables['geoipv4'].'` ADD INDEX(`geoname_id`)');
        }
        if (!$this->db->table_exists($this->tables['geoipv6'])){
            $this->dbforge->add_field(array(
                'network' => array('type' => 'VARCHAR', 'constraint' => '45'),
                'geoname_id' => array('type' => 'INT', 'unsigned' => true),
                'latitude' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'longitude' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => '512', 'null' => true),
                'accuracy_radius' => array('type' => 'INT', 'unsigned' => true),
            ));
            $this->dbforge->add_key('id');
            $this->dbforge->create_table($this->tables['geoipv6']);
            $this->db->query('ALTER TABLE `'.$this->tables['geoipv6'].'` ADD INDEX(`geoname_id`)');
        }
    }

    public function set_country($data) {
        // $data['geoname_id', 'continent_code', 'continent_name', 'country_iso_code', 'country_name', 'is_in_european_union']
        // обновляем континетты
        $count_cont = $this->db->where(array('id' => $data['continent_code']))
                               ->limit(1)
                               ->count_all_results($this->tables['continent']);
        if ($count_cont === 0) {
            $ins = array(
                'id' => $data['continent_code'],
                'name_'.$data['lang'] => trim($data['continent_name'], "\""),
            );
            $this->db->insert($this->tables['continent'], $ins);
        } else {
            $upd = array(
                'name_'.$data['lang'] => trim($data['continent_name'], "\""),
            );
            $this->db->update($this->tables['continent'], $upd, array('id' => $data['continent_code']));
        }
        // обновляем страны
        $count_country = $this->db->where(array('id' => $data['geoname_id']))
                               ->limit(1)
                               ->count_all_results($this->tables['country']);
        if ($count_country === 0) {
            $ins = array(
                'id' => $data['geoname_id'],
                'continent_id' => $data['continent_code'],
                'country_iso_code' => $data['country_iso_code'],
                'name_'.$data['lang'] => trim($data['country_name'], "\""),
                'is_in_european_union' => $data['is_in_european_union'],
            );
            $this->db->insert($this->tables['country'], $ins);
        } else {
            $upd = array(
                'continent_id' => $data['continent_code'],
                'country_iso_code' => $data['country_iso_code'],
                'name_'.$data['lang'] => trim($data['country_name'], "\""),
                'is_in_european_union' => $data['is_in_european_union'],
            );
            $this->db->update($this->tables['country'], $upd, array('id' => $data['geoname_id']));
        }
    }
}