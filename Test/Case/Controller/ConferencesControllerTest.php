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
	  $this->Conference = ClassRegistry::init('Conference');
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
	  //debug($this->vars);
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


	public function testIndexJson() {
          $this->testIndex('conferences/index.json',5,'Json');
          //debug($this->headers);
          //debug($this->vars);
        }

	public function testIndexJsonTags() {
          $this->testIndex('ag-ap.json',2,'Json Tags');
          //debug($this->headers);
          //debug($this->vars);
        }
	public function testIndexXML() {
          $this->testIndex('conferences/index.xml',5,'XML');
          //debug($this->headers);
          //debug($this->vars);
        }

	public function testIndexXMLTags() {
          $this->testIndex('ag-ap.xml',2,'XML Tags');
          //debug($this->headers);
          //debug($this->vars);
        }
	public function testIndexICS() {
          $this->testIndex('conferences/index.ics',5,'ICS');
          //debug($this->headers);
          //debug($this->vars);
        }

	public function testIndexICSTags() {
          $this->testIndex('ag-ap.ics',2,'ICS Tags');
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
	  $result =$this->testAction('/conferences/about', array('return'=>'contents'));
	  debug(substr($result,1500,1550));
	}


/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	  $result = $this->testAction('/conferences/view/4', array('return'=>'contents'));
	  echo "<h3>Testing View</h3>";
	  debug(substr($result,1500,1550));
	}

	public function testIcal() {
	  echo "<h3>Testing ical</h3>";
	  $result = $this->testAction('/conferences/view/4.ics');
	  $expected = null;
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
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	  echo "<h3>Testing delete</h3>";
	  $this->Conference->id = 4;
	  debug($this->Conference->read('title'));
	  $result = $this->testAction('/conferences/delete/4/wrong');
	  $this->assertEqual((bool)$this->Conference->read(),true);
	  $result = $this->testAction('/conferences/delete/4/key4');
	  $this->assertEqual((bool)$this->Conference->read(),false);
	  //debug(array('id'=>$this->Conference->id));
	  //debug($result);
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
