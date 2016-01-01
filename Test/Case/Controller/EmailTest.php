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


	public function testPrepEmail() {
	  echo "<h3>Testing email headers</h3>";
	  $Conferences = $this
	    ->generate('Conferences', 
		       array(
			     'components' 
			     => array(
				      'Session',
				      'Email' 
				      => array('send')
				      )
			     ));
	}

	public function testPrepEmailContent() {
	  $result = $this->testAction('/conferences/prepEmail/4');
	  //echo "<h3>Testing email headers</h3>";
	  /*
	  debug(array('from'=>$result->from(),
		      'to'=>$result->to(),
		      'subject'=>$result->subject(),
		      'cc'=>$result->cc(),
		      'bcc'=>$result->bcc(),
		      ));
	  */
	  echo "<h3>Testing content of email</h3>";
	  debug($result);
	}



}
