<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

	public function __construct() {
		parent::__construct();
	}

	public function up() {
		$data = array(
			'id'              => '0',
			'user_id'                => '0',
			'name'                => 'default',
		);
		$this->db->insert('friend_group', $data);
	}

	public function down() {
	}
}
