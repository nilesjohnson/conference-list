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

	public function setUp() {
	  parent::setUp();
	  $Controller = new Controller();
	  //$this->Conference = ClassRegistry::init('Conference');
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex($t='',$e=5,$h='Index') {
	  echo "<h3>Testing ".$h."</h3>";
	  $action = '/'.$t;
	  echo "<p>Action: '".$action."'</p>";
	  $result =$this->testAction($action,array('method'=>'get'));
	  debug($this->vars);
	  $this->assertEqual($this->vars['view_title'],'Upcoming Meetings');
	  echo "<p>".$e." conferences</p>";
	  debug(array('number of conferences' => count($this->vars['conferences']),
		      'view title' => $this->vars['view_title']
		      ));
	  $this->assertEqual(count($this->vars['conferences']),$e);
	  //debug($this->Conference->data);
	  //debug($this->vars['conferences']);
	}

        public function testTags() {
	  $this->testIndex('ag',1, 'Index Tags');
        }

        public function testTags2() {
	  $this->testIndex('ap-ag',2, 'Index Tags');
        }

	/*
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
	*/

	public function testIndexRSS() {
	  $this->testIndex('conferences/index.rss',5,'RSS');
	  //debug($this->headers);
	  //debug($this->vars);
	}

	public function testIndexRSSTags() {
	  $this->testIndex('ag-ap.rss',2,'RSS Tags');
	  //debug($this->headers);
	  //debug($this->vars);
	}

/**
 * testAbout method
 *
 * @return void
 */
	public function testAbout() {
	  echo "<h3>Testing About</h3>";
	  $result =$this->testAction('/conferences/about');
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
	  echo "<h3>Testing ical</h3>";
	  $result = $this->testAction('/conferences/ical/4');
	  $expected = 'BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
DTSTART:20501223
DTEND:20501226
LOCATION:City 4; Country 4
SUMMARY:Phasellus feugiat conference 4
URL:http://www.example4.net
END:VEVENT
END:VCALENDAR';
	  debug($result);
	  $this->assertEqual($result,$expected);
	}

	public function testGcal() {
	  echo "<h3>Testing gcal</h3>";
	  $result = $this->testAction('/conferences/gcal/4');
	  $expected = 'http://www.google.com/calendar/event?action=TEMPLATE&text=Phasellus+feugiat+conference+4&dates=20501223/20501226&details=';
	  debug($result);
	  $this->assertEqual(substr($result,0,121),$expected);
	}


/**
 * testAdd method
 *
 * @return void
 */

	public function testAdd() {
	  echo "<h3>Testing add (empty)</h3>";
	  $result = $this->testAction('/conferences/add');
	  debug($result);
	}



/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	  echo "<h3>Testing edit</h3>";
	  $this->testAction('/conferences/edit/4', 
			    array('data'
				  =>array('Conference' =>
					  array('title' => 'New Announcement'),
					  'Tag' => array('Tag' => 'mytag')
					  ),
				  )
			    );
	  $this->assertContains('/', $this->headers['Location']);
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	  echo "<h3>Testing delete</h3>";
	  $result = $this->testAction('/conferences/delete/4');
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
