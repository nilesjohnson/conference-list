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


	public function testNone() {
	  $result = $this->Conference;
	  $expected = true;
	  debug($result);
	  //$this->assertEquals($expected,$result);
	}

	public function testMultiEmail() {
	  $result = $this->Conference->multiEmail('em1@host1.com,em2@host2.com, em3@host3.com , em4@host4.com');
	  $expected = true;
	  //$this->assertEquals($expected,$result);
	
	}	


	public function testBeforeSave() {
	  $this->Conference->id = 2;
	  //$this->set('conference', $this->Conference->read());
	  $result = $this->Conference->beforeSave();
	  debug($result);
	  //$this->assertEquals(true,$result);
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
