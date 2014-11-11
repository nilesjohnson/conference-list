<?php

App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('MathCaptchaComponent', 'Controller/Component');


class TestController extends Controller {
  public $var = null;
}

class MathCaptchaComponentTest extends CakeTestCase {



  public function setUp() {
    parent::setUp();
    // Setup our component and fake test controller
    $Collection = new ComponentCollection();
    $this->MathCaptchaComponent = new MathCaptchaComponent($Collection);
    $CakeRequest = new CakeRequest();
    $CakeResponse = new CakeResponse();
    $this->Controller = new TestController($CakeRequest, $CakeResponse);
    $this->MathCaptchaComponent->startup($this->Controller);
  }

  public function testGenerateEquation() {
    $result = $this->MathCaptchaComponent->generateEquation();
    debug($result);
  } 

  /*
    public function testAdjust() {
        // Test our adjust method with different parameter settings
        $this->MathCaptchaComponent->adjust();
        $this->assertEquals(20, $this->Controller->paginate['limit']);

        $this->MathCaptchaComponent->adjust('medium');
        $this->assertEquals(50, $this->Controller->paginate['limit']);

        $this->MathCaptchaComponent->adjust('long');
        $this->assertEquals(100, $this->Controller->paginate['limit']);
    }
  */
  public function tearDown() {
    parent::tearDown();
    // Clean up after we're done
    unset($this->MathCaptchaComponent);
    unset($this->Controller);
  }
}

?>