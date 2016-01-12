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
	public function stubEmail() {
	  $controller = $this->generate('Conferences', 
					array('methods' 
					      => array('_getEmailer',),
					      'components' 
					      => array('Session',)
					      ));
	  $this->emailer = new CakeEmail();
	  $this->emailer->transport('Debug');  //don't actually send email
	  return $controller;
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
	  $controller = $this->stubEmail();
	  $controller->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  $controller
	    ->expects($this->any())
	    ->method('_getEmailer')
	    ->will($this->returnValue($this->emailer));
	  $this->Conference->id = 3;
	  //debug(array('id'=>$this->Conference->id));
	  $this->Conference->read();
	  debug($this->Conference->data['Conference']['title']);
	  $result = $this->testAction('/conferences/save_and_send',
	  			      array('data' => $this->Conference->data));
	  //test redirect
	  $this->assertContains('/conferences/index/at-ac', $this->headers['Location']);
	}


/**
 * testAdd method
 *
 * @return void
 */

	public function testAdd() {
	  echo "<h3>Testing add (empty)</h3>";
	  $controller = $this->stubEmail();
	  /*
	  $controller->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  */
	  $controller
	    ->expects($this->any())
	    ->method('_getEmailer')
	    ->will($this->returnValue($this->emailer));

	  $result = $this->testAction('/conferences/add');
	  debug($this->contents);
	  debug($this->view);
	  //$this->assertRegExp('/<html/', $this->contents);
	  //$this->assertRegExp('/<form/', $this->view);
	}


/**
 * testEdit method
 *
 * @return void
 */
	public function testEditNoKey() {
	  echo "<h3>Testing edit with no key</h3>";

	  $controller = $this->stubEmail();
	  $controller->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  $controller
	    ->expects($this->any())
	    ->method('_getEmailer')
	    ->will($this->returnValue($this->emailer));

	  $this->Conference->id = 4;
	  $this->Conference->read();
	  debug('BEFORE EDIT');
	  debug($this->Conference->data['Conference']['title']);

	  //attempt to edit with no key
	  $this->Conference->data['Tag'] = array('Tag' => array(1,2,3));
	  $this->Conference->data['Conference']['title'] = 'new title 4';
	  $result = $this->testAction('/conferences/edit/4',
	  			      array('data' => $this->Conference->data));

	  $this->Conference->id = 4;
	  $this->Conference->read();
	  debug('AFTER FAILED EDIT');
	  debug($this->Conference->data['Conference']['title']);
	  $this->assertEqual($this->Conference->data['Conference']['title'],'Phasellus feugiat conference 4');


	  $this->assertContains('/', $this->headers['Location']);
	}



	public function testEditYesKey() {
	  echo "<h3>Testing edit with correct key</h3>";

	  $controller = $this->stubEmail();
	  $controller->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  $controller
	    ->expects($this->any())
	    ->method('_getEmailer')
	    ->will($this->returnValue($this->emailer));

	  $this->Conference->id = 4;
	  $this->Conference->read();
	  debug('BEFORE EDIT');
	  debug($this->Conference->data['Conference']['title']);

	  //edit with key
	  $this->Conference->data['Tag'] = array('Tag' => array(1,2,3));
	  $this->Conference->data['Conference']['title'] = 'new title 4';
	  $result = $this->testAction('/conferences/edit/4/key4',
	  			      array('data' => $this->Conference->data));
	  $this->Conference->id = 4;
	  $this->Conference->read();
	  debug('AFTER SUCCESSFUL EDIT');
	  debug($this->Conference->data['Conference']['title']);
	  $this->assertEqual($this->Conference->data['Conference']['title'],'new title 4');

	  $this->assertContains('/', $this->headers['Location']);
	}


}
