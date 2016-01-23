<?php
App::uses('ConferencesController','Controller');
App::uses('View','View');
App::uses('GcalHelper','View/Helper');

class GcalHelperTest extends CakeTestCase {
  public function setUp() {
    parent::setUp();
    $Controller = new ConferencesController();
    $View = new View();
    $this->gcal = new GcalHelper($View);
  }
  public function testGcal() {
    echo "<h3>Gcal URL Test</h3>";
    $expected = 'http://www.google.com/calendar/event?action=TEMPLATE&text=title&dates=20140101/20140202&details=http://url.com&location=city%3B+country&trp=false&sprop=conflist%2Furl&sprop=name:conflist+name';
    $result = $this->gcal->gcal_url('1','2014-01-01','2014-02-01','title','city','country','http://url.com','conflist/url','conflist name');
    debug($result);
    $this->assertEquals($expected,$result);
  }
}
?>