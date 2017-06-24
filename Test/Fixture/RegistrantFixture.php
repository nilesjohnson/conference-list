<?php
/**
 * TagFixture
 *
 */
class RegistrantFixture extends CakeTestFixture {
        public $useDbConfig = 'test';
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
public $records = array(
			array('id'=>1, 
			      'date' => '2017-01-01',
			      'edit_key' => 'a',
			      'first_name' => 'reg',
			      'last_name' => 'one',
			      'email' => 'a@a.com',
			      'affiliation' => 'univ a',
			      'webpage' => 'a.com',
			      'request_pub' => 1,
			      'request_fund' => 1,
			      'request_a' => 0,
			      'request_b' => 1,
			      'request_c' => 0,
			      'comment' => 'test comment'),
			array('id'=>2, 
			      'date' => '2017-02-02',
			      'edit_key' => 'b',
			      'first_name' => 'reg',
			      'last_name' => 'two',
			      'email' => 'b@b.com',
			      'affiliation' => 'univ b',
			      'webpage' => 'b.com',
			      'request_pub' => 1,
			      'request_fund' => 1,
			      'request_a' => 0,
			      'request_b' => 1,
			      'request_c' => 0,
			      'comment' => 'test comment'),
			array('id'=>3, 
			      'date' => '2017-03-03',
			      'edit_key' => 'c',
			      'first_name' => 'reg',
			      'last_name' => 'three',
			      'email' => 'c@c.com',
			      'affiliation' => 'univ c',
			      'webpage' => 'c.com',
			      'request_pub' => 0,
			      'request_fund' => 1,
			      'request_a' => 0,
			      'request_b' => 1,
			      'request_c' => 0,
			      'comment' => 'test comment'),
			array('id'=>4, 
			      'date' => '2017-04-04',
			      'edit_key' => 'd',
			      'first_name' => 'reg',
			      'last_name' => 'four',
			      'email' => 'd@d.com',
			      'affiliation' => 'univ d',
			      'webpage' => 'd.com',
			      'request_pub' => 1,
			      'request_fund' => 1,
			      'request_a' => 0,
			      'request_b' => 1,
			      'request_c' => 0,
			      'comment' => 'test comment'),
			     ); 

}
