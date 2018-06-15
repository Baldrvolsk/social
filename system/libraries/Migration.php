<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration Class
 *
 * All migrations should implement this, forces up() and down() and gives
 * access to the CI super-global.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Reactor Engineers
 * @link
 */
class CI_Migration {

	/**
	 * Whether the library is enabled
	 *
	 * @var bool
	 */
	protected $_migration_enabled = FALSE;

	/**
	 * Path to migration classes
	 *
	 * @var string
	 */
	protected $_migration_path = NULL;

	/**
	 * Database table with migration info
	 *
	 * @var string
	 */
	protected $_migration_table = 'migrations';

	/**
	 * Whether to automatically run migrations
	 *
	 * @var	bool
	 */
	protected $_migration_auto_latest = FALSE;

	/**
	 * Migration basename regex
	 *
	 * @var string
	 */
	protected $_migration_regex;

	/**
	 * Error message
	 *
	 * @var string
	 */
	protected $_error_string = '';

	/**
	 * Initialize Migration Class
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function __construct($config = array()) {
		// Only run this constructor on main library load
		if (!in_array(get_class($this), array('CI_Migration', config_item('subclass_prefix').'Migration'), TRUE)) {
			return;
		}

		foreach ($config as $key => $val) {
			$this->{'_'.$key} = $val;
		}

		log_message('info', 'Migrations Class Initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE) {
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path !== '' OR $this->_migration_path = APPPATH.'migrations'.DIRECTORY_SEPARATOR;
        // Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();

		// Make sure the migration table name was set.
		if (empty($this->_migration_table)) {
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// Migration basename regex
		$this->_migration_regex = '/^\d{3,5}_\w_(\w+)$/';

		// If the migrations table is missing, make it
		if (!$this->db->table_exists($this->_migration_table)) {
            $this->dbforge->add_field(array(
				'version' => array('type' => 'VARCHAR', 'constraint' => 7),
                'dt' => array('type' => 'TIMESTAMP'),
                'series' => array('type' => 'INT'),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);
		}

		// Do we auto migrate to the latest migration?
		if ($this->_migration_auto_latest === TRUE && ! $this->latest()) {
			show_error($this->error_string());
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate to a schema version
	 *
	 * Calls each migration step required to get to the schema version of
	 * choice
	 *
	 * @param	string	$target_version	Target schema version
	 * @return	mixed	TRUE if no migrations are found, current version string on success, FALSE on failure
	 */
	public function version($type, $ext = null) {
		$latest_series = $this->_get_latest_series();

		switch ($type) {
            case 'latest':
                $migrations = $ext;
                $method = 'up';
                break;
            default:
                $this->_error_string = sprintf($this->lang->line('migration_error_type'), $type);
                return FALSE;
        }

		// Validate all available migrations within our target range.
		//
		// Unfortunately, we'll have to use another loop to run them
		// in order to avoid leaving the procedure in a broken state.
		$pending = array();
		foreach ($migrations as $number => $file) {

			include_once($file);
			$class = 'Migration_'.strtolower($this->_get_migration_name(basename($file, '.php')));

			// Validate the migration file structure
			if (!class_exists($class, FALSE)) {
				$this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);
				return FALSE;
			} elseif (!is_callable(array($class, $method))) {
				$this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
				return FALSE;
			}

			$pending[$number] = array($class, $method);
		}

		// Now just run the necessary migrations
		foreach ($pending as $number => $migration) {
			log_message('debug', 'Migrating '.$method.' to version '.$number);

			$migration[0] = new $migration[0];
			call_user_func($migration);
			if ($migration[1] === 'up') {
                $this->_add_migration($number, $latest_series+1);
            }
		}

        $current_version = $this->_get_latest_migration();
		log_message('debug', 'Finished migrating to '.$current_version);
		return $current_version;
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the schema to the latest migration
	 *
	 * @return	mixed	Current version string on success, FALSE on failure
	 */
	public function latest() {
		$migrations = $this->find_migrations();
        $f_d = array_diff_key($migrations['f'], $migrations['d']);
		if (empty($f_d)) {
			$this->_error_string = $this->lang->line('migration_none_found');
			return FALSE;
		}

		return $this->version('latest', $f_d);
	}

	// --------------------------------------------------------------------

	/**
	 * Error string
	 *
	 * @return	string	Error message returned as a string
	 */
	public function error_string() {
		return $this->_error_string;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves list of available migration scripts
	 *
	 * @return	array	list of migration file paths sorted by version
	 */
	public function find_migrations($print = null) {
		$migrations = array();
		$f_migrations = array();
		$d_migrations = array();

		// Load all *_*.php files in the migrations path
		foreach (glob($this->_migration_path.'*_*.php') as $file) {
			$name = basename($file, '.php');

			// Filter out non-migration files
			if (preg_match($this->_migration_regex, $name)) {
				$number = $this->_get_migration_number($name);

				// There cannot be duplicate migration numbers
				if (isset($f_migrations[$number])) {
					$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $number);
					show_error($this->_error_string);
				}

				$f_migrations[$number] = $file;
			}
		}
        ksort($f_migrations);
        $migrations['f'] = $f_migrations;
        if ($print) {
            echo'<pre>';var_dump($f_migrations);echo'</pre>';
        }
		// Load all migrations from DB
        $query = $this->db->get($this->_migration_table);

        foreach ($query->result() as $row) {
            $d_migrations[$row->version] = array(
                'dt' => $row->dt,
                'series' => $row->series,
            );
        }
        ksort($d_migrations);
        $migrations['d'] = $d_migrations;
        if ($print) {
            echo'<pre>';var_dump($d_migrations);echo'</pre>';
        }
        if (!empty($d_migrations)) {
            $d_f = array_diff_key($d_migrations, $f_migrations);
            if ($print) {
                echo'<pre>';var_dump($d_f);echo'</pre>';
            }
            if (!empty($d_f)) {
                $string = implode(', ', array_keys($d_f));
                $this->_error_string = sprintf($this->lang->line('migration_not_found_file_version'), $string);
                show_error($this->_error_string);
            }
        }

		return $migrations;
	}

	// --------------------------------------------------------------------

	/**
	 * Extracts the migration number from a filename
	 *
	 * @param	string	$migration
	 * @return	string	Numeric portion of a migration filename
	 */
    protected function _get_migration_number($migration) {
        $m = explode('_', $migration);
        return sprintf('%05d', $m[0]).'_'.$m[1];
    }

	// --------------------------------------------------------------------

	/**
	 * Extracts the migration class name from a filename
	 *
	 * @param	string	$migration
	 * @return	string	text portion of a migration filename
	 */
	protected function _get_migration_name($migration) {
		$parts = explode('_', $migration);
		array_shift($parts);
        array_shift($parts);
		return implode('_', $parts);
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 *
	 */
	protected function _add_migration($number, $series) {
	    $data = array(
            'version' => $number,
            'dt' => mdate('%Y-%m-%d %H:%i:%s', now()),
            'series' => $series,
        );
		$this->db->insert($this->_migration_table, $data);
	}

	// --------------------------------------------------------------------

    /**
     * Stores the current schema version
     *
     *
     */
    protected function _delete_migration($type, $number) {
        $this->db->delete($this->_migration_table, array($type => $number));
    }

    // --------------------------------------------------------------------

    /**
     * Stores the current schema version
     *
     *
     */
    protected function _get_latest_series() {
        $this->db->select_max('series');
        $query = $this->db->get($this->_migration_table);
        $row = $query->row();
        return $row->series;
    }

    /**
     * Stores the current schema version
     *
     *
     */
    protected function _get_latest_migration() {
        $this->db->select('version');
        $where = "`dt` = (SELECT MAX(`dt`) FROM `".$this->_migration_table."`)";
        $this->db->where($where, null, false);
        $query = $this->db->get($this->_migration_table);
        $row = $query->row();
        return $row->version;
    }

    // --------------------------------------------------------------------

	/**
	 * Enable the use of CI super-global
	 *
	 * @param	string	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

}
