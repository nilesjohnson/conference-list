<?php


class DATABASE_CONFIG {
        /*
 	 * Set some defaults
	 */
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'test_conflist',
	);
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'conflist',
	);

	/*
	 * Read updates from private config file
	 * app/Config/conflistPrivateConfig.php
	 */
        public function __construct() {
	        $this->test = Configure::read('database.test');
	        $this->default = Configure::read('database.default');
	}


}
