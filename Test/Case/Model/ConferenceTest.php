<?php
App::uses('Conference', 'Model');

/**
 * Conference Test Case
 *
 */
class ConferenceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.conference'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
	  parent::setUp();
	  $this->Conference = ClassRegistry::init('Conference');
	}


	/*
	public function testNone() {
	  $result = $this->Conference;
	  $expected = true;
	  //debug($result);
	  //$this->assertEquals($expected,$result);
	}
	*/

	public function testMultiEmail() {
	  $check = array('contact_email' => 'em1@host1.com,em2@host2.com, em3@host3.com   em4@host4.com');
	  $result = $this->Conference->multiEmail($check);
	  $expected = true;
	  debug($check);
	  $this->assertEquals($expected,$result);
	}	


	public function testBeforeSave() {
	  $conferences = $this->Conference->find('all');
	  //debug($conferences);
	  foreach ($conferences as $entry) {
	    $this->Conference->id=$entry['Conference']['id'];
	    $this->Conference->read();
	    $result = $this->Conference->beforeSave();
	    debug($this->Conference->data);
	    $this->assertEquals(true,$result);
	  }
	}



/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Conference);

		parent::tearDown();
	}

}
