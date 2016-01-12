<?php
App::uses('ConferencesController','Controller');
App::uses('View','View');
App::uses('DisplayHelper','View/Helper');

class DisplayHelperTest extends CakeTestCase {
  public function setUp() {
    parent::setUp();
    //$Controller = new ConferencesController();
    //$Controller->Conference = ClassRegistry::init('Conference');
    $View = new View();
    $this->display = new DisplayHelper($View);

    //$Controller->Conference->id = 4;
    //debug(array('id'=>$Controller->Conference->id));
    //$Controller->Conference->read();    
  }

  public function testAsArray() {
    echo "<h2>Display as array</h2>";
    $result=$this->display->asArray(array('test'=>'data','test two'=>'data2'));
    debug($result);
    //$this->assertEquals(true,$result);
  }
  public function testAsText() {
    echo "<h2>Display as text</h2>";
    $result=$this->display->asText(array('test'=>'data','test two'=>'data2'));
    debug($result);
    //$this->assertEquals(true,$result);
  }
}
?>