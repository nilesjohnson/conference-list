<?php
App::uses('ConferencesController', 'Controller');

/**
 * ConferencesController Test Case
 *
 */
class ConferencesControllerTest extends ControllerTestCase {

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
	public function testIndex() {
	  $result =$this->testAction('/',array('method'=>'get'));
	  $this->assertEqual($this->vars['view_title'],'Upcoming Meetings');
	  $this->assertEqual(count($this->vars['conferences']) > 0,true);
	  echo "<h3>Testing Index</h3>";
	  //debug($this->vars);
	  debug(array('number of conferences' => count($this->vars['conferences']),
		      'view title' => $this->vars['view_title']
		      ));
	}

	
	public function testIndexPast() {
	  $result =$this->testAction('/conferences/index/all',array('method'=>'get'));
	  $this->assertEqual($this->vars['view_title'],'All Meetings');
	  $this->assertEqual(count($this->vars['conferences']) > 0,true);
	  echo "<h3>Testing Index Past</h3>";
	  debug(array('number of conferences' => count($this->vars['conferences']),
		      'view title' => $this->vars['view_title']
		      ));
	}

	public function testIndexByCountry() {
	  $result =$this->testAction('/conferences/index/country',array('method'=>'get'));
	  $this->assertEqual($this->vars['view_title'],'Upcoming Meetings');
	  $this->assertEqual(count($this->vars['conferences']) > 0,true);
	  $this->assertEqual($this->vars['sort_condition'],'country');
	  echo "<h3>Testing Index By Country</h3>";
	  debug(array('number of conferences' => count($this->vars['conferences']),
		      'view title' => $this->vars['view_title']
		      ));
	}

	public function testIndexRSS() {
	  $result =$this->testAction('/conferences/index.rss',array('method'=>'get'));
	  echo "<h3>Testing RSS</h3>";
	  debug(array('number of conferences' => count($this->vars['conferences']),
		      'view title' => $this->vars['view_title']
		      ));
	  $this->assertEqual(count($this->vars['conferences']),4);
	  //debug($this->headers);
	  //debug($this->vars);
	}

/**
 * testAbout method
 *
 * @return void
 */
	public function testAbout() {
	  $result =$this->testAction('/conferences/about');
	  echo "<h3>Testing About</h3>";
	  debug($result);
	}


/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	  $result = $this->testAction('/conferences/view/4');
	  echo "<h3>Testing View</h3>";
	  debug($result);
	}

	public function testIcal() {
	  $result = $this->testAction('/conferences/ical/4');
	  $expected = 'BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
DTSTART:20501223
DTEND:20501226
LOCATION:City 4; Country 4
SUMMARY:Phasellus feugiat conference
URL:http://www.example4.net
END:VEVENT
END:VCALENDAR';
	  echo "<h3>Testing ical</h3>";
	  debug($result);
	  $this->assertEqual($result,$expected);
	}

	public function testGcal() {
	  $result = $this->testAction('/conferences/gcal/4');
	  $expected = 'http://www.google.com/calendar/event?action=TEMPLATE&text=Phasellus+feugiat+conference&dates=20501223/20501226&details=http://www.example4.net&location=City+4%3B+Country+4&trp=false&sprop=http%3A%2F%2Fwww.nilesjohnson.net%2Fconflist-test&sprop=name:ConfList-Test';
	  echo "<h3>Testing gcal</h3>";
	  debug($result);
	  $this->assertEqual($result,$expected);
	}


/**
 * testAdd method
 *
 * @return void
 */

	public function testAdd() {
	  $Conferences = $this->generate('Conferences', 
					 array('components'
					       =>array('Session',
						       'Email' 
						       =>array('send')
						       )
					       ));
	  $Conferences->Session
	    ->expects($this->once())
	    ->method('setFlash');
	  /*
	    $Conferences->Email
	    ->expects($this->once())
	    ->method('send')
	    ->will($this->returnValue(true));
	  */
	  $this->testAction('/conferences/edit/4', 
			    array('data'
				  =>array('Conference' 
					  =>array('title' => 'New Announcement')
					  )
				  ));
	  $this->assertContains('/', $this->headers['Location']);
	  echo "<h3>Testing add</h3>";
	  debug($this->headers);
	}



/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	  $result = $this->testAction('/conferences/edit/4');
	  echo "<h3>Testing edit</h3>";
	  debug($result);
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	  $result = $this->testAction('/conferences/delete/4');
	  echo "<h3>Testing delete</h3>";
	  debug($result);
	}


	public function testPrepEmail() {
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
	  $result = $this->testAction('/conferences/prepEmail',
				      array(
					    'data'
					    => array(
						     'Conference' 
						     => array('title' 
							      => 'My New Conference',
							      'contact_email' 
							      => 'test@example.com')
						     )
					    ));
	  echo "<h3>Testing email headers</h3>";
	  debug(array('from'=>$result->from(),
		      'to'=>$result->to(),
		      'subject'=>$result->subject(),
		      'cc'=>$result->cc(),
		      'bcc'=>$result->bcc(),
		      ));
	}

	public function testPrepEmailContent() {
	  $result = $this->testAction('/conferences/prepEmail/4');
	  echo "<h3>Testing content of email</h3>";
	  debug($result);
	}


/**
 * testAdminIndex method
 *
 * @return void
 */
//	public function testAdminIndex() {
//	}

/**
 * testAdminView method
 *
 * @return void
 */
//	public function testAdminView() {
//	}

/**
 * testAdminAdd method
 *
 * @return void
 */
//	public function testAdminAdd() {
//	}

/**
 * testAdminEdit method
 *
 * @return void
 */
//	public function testAdminEdit() {
//	}

/**
 * testAdminDelete method
 *
 * @return void
 */
//	public function testAdminDelete() {
//	}

}
