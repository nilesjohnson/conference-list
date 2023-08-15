<?php
/**
 * ConferenceFixture
 *
 */
class ConferenceFixture extends CakeTestFixture {
        public $useDbConfig = 'test';
/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'edit_key' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'start_date' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'end_date' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'institution' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'region' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'country' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'meeting_type' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject_area' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'homepage' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'contact_name' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'contact_email' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => 'datetime',
		'modified' => 'datetime',
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
		array(
			'id' => 1,
			'edit_key' => 'key1',
			'title' => 'Lorem ipsum conference 1',
			'start_date' => '2060-01-23',
			'end_date' => '2060-01-25',
			'duration' => 3,
			'institution' => 'University 1',
			'city' => 'City 1',
			'region' => 'Region 1',
			'country' => 'Country 1',
			'meeting_type' => 'conference',
			'subject_area' => '',
			'homepage' => 'http://www.example.net',
			'contact_name' => 'Contact info',
			'contact_email' => 'none@example.net',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2060-01-20 12:43:00',
			'modified' => '2060-01-20 12:43:00',
		),
		array(
			'id' => 2,
			'edit_key' => 'key2',
			'title' => 'Aliquet feugiat conference 2',
			'start_date' => '2060-02-23',
			'end_date' => '2060-02-25',
			'duration' => 3,
			'institution' => 'University 2',
			'city' => 'City 2',
			'region' => 'Region 2',
			'country' => 'Country 2',
			'meeting_type' => 'conference',
			'subject_area' => '',
			'homepage' => 'http://www.example2.net',
			'contact_name' => 'Contact info',
			'contact_email' => 'none@example2.net',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2060-01-20 12:43:00',
			'modified' => '2060-01-20 12:43:00',
		),
		array(
			'id' => 3,
			'edit_key' => 'key3',
			'title' => 'Convallis morbi conference 3',
			'start_date' => '2062-05-23',
			'end_date' => '2062-05-25',
			'duration' => 3,
			'institution' => 'University 3',
			'city' => 'City 3',
			'region' => 'Region 3',
			'country' => 'Country 3',
			'meeting_type' => 'conference',
			'subject_area' => '',
			'homepage' => 'http://www.example3.net',
			'contact_name' => 'Contact info',
			'contact_email' => 'none@example3.net',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2060-01-20 12:43:00',
			'modified' => '2060-01-20 12:43:00',
		),
		array(
			'id' => 4,
			'edit_key' => 'key4',
			'title' => 'Phasellus feugiat conference 4',
			'start_date' => '2070-12-23',
			'end_date' => '2070-12-25',
			'duration' => 3,
			'institution' => 'University 4',
			'city' => 'City 4',
			'region' => 'Region 4',
			'country' => 'Country 4',
			'meeting_type' => 'conference',
			'subject_area' => '',
			'homepage' => 'http://www.example4.net',
			'contact_name' => 'Contact info',
			'contact_email' => 'none@example4.net,also-this@example4.net,  and-this@example4.net  one-more@example.net',
			'description' => '<p>Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus.</p>

<p>velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.</p>',
			'created' => '2060-01-20 12:43:00',
			'modified' => '2060-01-20 12:43:00',
		),
		array(
			'id' => 5,
			'edit_key' => 'key5',
			'title' => 'Dapibus velit conference 5',
			'start_date' => '2070-12-23',
			'end_date' => '2070-12-25',
			'duration' => 3,
			'institution' => 'University 5',
			'city' => 'City 5',
			'region' => 'Region 5',
			'country' => 'Country 5',
			'meeting_type' => 'conference',
			'subject_area' => '',
			'homepage' => 'http://www.example5.net',
			'contact_name' => 'Contact info',
			'contact_email' => 'none@example5.net,also-this@example5.net,  and-this@example5.net  one-more@example.net',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2060-01-20 12:43:00',
			'modified' => '2060-01-20 12:43:00',
		),
	);

}
