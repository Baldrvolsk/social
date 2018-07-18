<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_field_community extends CI_Migration {

    public function up() {
        $fields = array(
            'type' => array(
                'type' => "SET('open','close')",
                'default' => 'open'
            )
        );
        $this->dbforge->add_column('community', $fields);
    }

    public function down() {

    }
}
