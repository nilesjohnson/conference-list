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
	  echo "<h3>Testing content of email</h3>";
	  $result = $this->testAction('/conferences/prepEmail/4');
	  debug($result);
	  debug(substr($result,2,35));
	  $this->assertEqual(substr($result,2,35),"Thanks for adding your announcement");
	}

	public function testSaveAndSend() {
	  echo "<h3>Testing save_and_send</h3>";
	  /*
	    $Conferences = $this->generate('Conferences', 
					 array(
					       'components' => array(
								     'Session',
								     )
					       ));
	  $Conferences->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  */
	  $controller = $this->generate('Conferences', 
					array('methods' 
					      => array('_getEmailer',),
					      'components' 
					      => array('Session',)
					      ));
	  $emailer = new CakeEmail();
	  $emailer->transport('Debug');  //don't actually send email
	  $controller->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  $controller
	    ->expects($this->any())
	    ->method('_getEmailer')
	    ->will($this->returnValue($emailer));
	  $this->Conference->id = 3;
	  //debug(array('id'=>$this->Conference->id));
	  $this->Conference->read();
	  $result = $this->testAction('/conferences/save_and_send',
				      array('data' => $this->Conference->data));
	  //test redirect
	  $this->assertContains('/conferences/index/at-ac', $this->headers['Location']);
	}


}
