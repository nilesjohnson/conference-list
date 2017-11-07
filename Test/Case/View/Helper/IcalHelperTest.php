<?php
App::uses('ConferencesController','Controller');
App::uses('View','View');
App::uses('IcalHelper','View/Helper');

class IcalHelperTest extends CakeTestCase {
  public function setUp() {
    parent::setUp();
    $Controller = new ConferencesController();
    $View = new View();
    $this->ical = new IcalHelper($View);
  }
  public function test_vcal_event() {
    echo "<h3>VCAL Data Test</h3>";
    $result = $this->ical->vcal_event(3, 2017-01-01, 2017-01-05, 'test title', 'city', 'country', 'http://www.test.com');
    debug($result);
    $expected = 'BEGIN:VEVENT
DTSTART:2015
DTEND:20171108
LOCATION:city; country
SUMMARY:test title
URL:http://www.test.com
END:VEVENT
';
    $this->assertEquals($expected,$result);
  }
}
?>