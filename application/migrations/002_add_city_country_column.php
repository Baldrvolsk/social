<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_city_country_column extends CI_Migration {
	private $tables;

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();

		$this->load->config('ion_auth', TRUE);
		$this->tables = $this->config->item('tables', 'ion_auth');
	}

	public function up() {
        $fields = array(
            'city' => array('type' => 'MEDIUMINT'),
            'country' => array('type' => 'MEDIUMINT')
        );
        $this->dbforge->add_column('users', $fields);

	}

	public function down() {

	}
}
