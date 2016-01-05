<?php
App::uses('ConferencesController', 'Controller');

/**
 * Email Test Case
 *
 */
class EmailTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
				 'app.conference',
				 'app.tag',
				 'app.conferencesTag'
	);

/**
 * testIndex method
 *
 * @return void
 */

	public function setUp() {
	  parent::setUp();
	  $Controller = new Controller();
	  $this->Conference = ClassRegistry::init('Conference');
	}

	public function testPrepEmail() {
	  echo "<h3>Testing email headers</h3>";
	  $this->Conference->id = 4;
	  debug(array('id'=>$this->Conference->id));
	  $this->Conference->read();
	  //debug($this->Conference->data);
	  $result = $this->testAction('/conferences/prepEmail', 
				      array('data' => $this->Conference->data)
				      );
	  $headers = array('from'=>$result->from(),
			   'to'=>$result->to(),
			   'subject'=>$result->subject(),
			   'cc'=>$result->cc(),
			   'bcc'=>$result->bcc(),
			   );
	  debug($headers);
	  $this->assertEqual(count($headers['cc'])>0,true);
	  $this->assertEqual(count($headers['bcc'])>0,true);
	}

	public function testPrepEmailContent() {
	  $result = $this->testAction('/conferences/prepEmail/4');
	  echo "<h3>Testing content of email</h3>";
	  debug($result);
	  debug(substr($result,1,30));
	  $this->assertEqual(substr($result,1,35),"Thanks for adding your announcement");
	}



}
