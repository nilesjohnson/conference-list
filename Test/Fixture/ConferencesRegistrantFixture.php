<?php
/**
 * ConferencesRegistrantFixture
 *
 */
class ConferencesRegistrantFixture extends CakeTestFixture {
        public $useDbConfig = 'test';
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'conference_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'registrant_id' => array('type' => 'integer', 'null' => false, 
'default' => null, 'length' => 10, 'key' => 'primary'),
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
				      'conference_id'=>1,
				      'registrant_id'=>4),
				array('id'=>2,
				      'conference_id'=>1,
				      'registrant_id'=>1),
				array('id'=>3,
				      'conference_id'=>2,
				      'registrant_id'=>4),
				array('id'=>4,
				      'conference_id'=>2,
				      'registrant_id'=>1),
				array('id'=>5,
				      'conference_id'=>3,
				      'registrant_id'=>4),
				array('id'=>6,
				      'conference_id'=>3,
				      'registrant_id'=>1),
				array('id'=>7,
				      'conference_id'=>4,
				      'registrant_id'=>4),
				array('id'=>8,
				      'conference_id'=>4,
				      'registrant_id'=>2),
				array('id'=>9,
				      'conference_id'=>4,
				      'registrant_id'=>3),
				array('id'=>10,
				      'conference_id'=>5,
				      'registrant_id'=>4),
				array('id'=>11,
				      'conference_id'=>5,
				      'registrant_id'=>3),
	);

}
