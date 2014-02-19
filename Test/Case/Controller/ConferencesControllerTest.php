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
		'app.conference'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	$result =$this->testAction('/');
	debug($result);
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	$result = $this->testAction('/conferences/view/4');
	debug($result);
	}

/**
 * testAdd method
 *
 * @return void
 */

  public function testEdit() {
    $Conferences = $this->generate('Conferences', array(
      'components' => array(
      'Session',
      'Email' => array('send')
      )
      ));
    $Conferences->Session
      ->expects($this->once())
      ->method('setFlash');
    $Conferences->Email
      ->expects($this->once())
      ->method('send')
      ->will($this->returnValue(true));

    $this->testAction('/conferences/edit/4', array(
      'data' => array(
          'Conference' => array('title' => 'New Announcement')
      )
    ));
    $this->assertContains('/', $this->headers['Location']);
  }



/**
 * testEdit method
 *
 * @return void
 */
//	public function testEdit() {
//	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}


	public function testPrepEmail() {
	  $result = $this->prepEmail();
	  debug($result);
	}


/**
 * testAdminIndex method
 *
 * @return void
 */
	public function testAdminIndex() {
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
	}

/**
 * testAdminAdd method
 *
 * @return void
 */
	public function testAdminAdd() {
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
	}

/**
 * testAdminDelete method
 *
 * @return void
 */
	public function testAdminDelete() {
	}

}
