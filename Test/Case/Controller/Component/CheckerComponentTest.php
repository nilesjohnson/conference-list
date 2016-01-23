<?php
App::uses('ConferencesController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('CheckerComponent', 'Controller/Component');


class TestController extends ConferencesController {
  public $var = null;
}

class CheckerComponentTest extends CakeTestCase {



  public function setUp() {
    parent::setUp();
    // Setup our component and fake test controller
    $Collection = new ComponentCollection();
    $this->CheckerComponent = new CheckerComponent($Collection);
    $CakeRequest = new CakeRequest();
    $CakeResponse = new CakeResponse();
    $this->Controller = new TestController($CakeRequest, $CakeResponse);
    $this->CheckerComponent->startup($this->Controller);
    echo "<h2>Nothing to do here; Checker component uses validation from models</h2>";
  }

  public function testConferenceValid() {
    echo "<h3>Test Conference Validation</h3>";
    $this->CheckerComponent->initialize($this->Controller);
    //$result = $this->CheckerComponent->conferenceValid();
    //debug($result);
    //$this->assertContains(' + ',$result);
  } 

  public function testTagValid() {
    echo "<h3>Test Tag Validation</h3>";
    $this->CheckerComponent->initialize($this->Controller);
    //$result = $this->CheckerComponent->tagValid();
    //debug($result);
    //$this->assertContains(' + ',$result);
  } 

  public function tearDown() {
    parent::tearDown();
    // Clean up after we're done
    unset($this->CheckerComponent);
    unset($this->Controller);
  }
}

?>