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
	  echo "<p>Using fake data for 'New Announcement' with tags 'at', 'ct' and 'ag'</p>";
	  $result = $this->testAction('/conferences/prepEmail', 
			    array('data'
				  =>array('Conference' =>
					  array('title' => 'New Announcement',
						'contact_email' => 'test@test.com other@test.com',
						),
					  'Tag' => array(array('name'=>'at.algebraic-topology'),
							 array('name'=>'ct.category-theory'),
							 array('name'=>'ag.algebraic-geometry'),
							 )
					  ),
				  )
			    );
	  $headers = array('from'=>$result->from(),
			   'to'=>$result->to(),
			   'subject'=>$result->subject(),
			   'cc'=>$result->cc(),
			   'bcc'=>$result->bcc(),
			   );
	  debug($headers);
	  $this->assertEqual(count($headers['cc']),3);
	  $this->assertEqual(count($headers['bcc']),2);
	}

	public function testPrepEmailContent() {
	  $result = $this->testAction('/conferences/prepEmail/4');
	  echo "<h3>Testing content of email</h3>";
	  debug($result);
	  debug(substr($result,1,30));
	  $this->assertEqual(substr($result,1,35),"Thanks for adding your announcement");
	}



}
