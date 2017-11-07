<?php
/* /app/views/helpers/ical.php */

class IcalHelper extends AppHelper {
  public function __construct(View $view, $settings = array()) {
    parent::__construct($view, $settings);
    //debug($settings);
    $site_url = Configure::read('site.home');
    $site_name = Configure::read('site.name');

  }
  

  public function vcal_begin() {
    return "BEGIN:VCALENDAR\n".
      "VERSION:2.0\n";
  }

  public function vcal_end() {
    return "END:VCALENDAR";
  }

  public function vcal_event($id, $start_date, $end_date, $title, $city, $country, $homepage, $conflist_url, $conflist_name) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $vcal = "BEGIN:VEVENT\n".
      "DTSTART:".$start_string."\n".
      "DTEND:".$end_string."\n".
      "LOCATION:".$location."\n".
      "SUMMARY:".$title."\n".
      "URL:".$homepage."\n".
      "END:VEVENT\n";
    return $vcal;  
  }

  public function vcal($conferences) {
    // takes an array of conferences and outputs a vcalendar
    $vcal = $this->vcal_begin();
    foreach ($conferences as $conference) {
      $vcal .= $this->vcal_event($conference['id'], 
				       $conference['start_date'], 
				       $conference['end_date'],
				       $conference['title'],
				       $conference['city'],
				       $conference['country'],
				       $conference['homepage'],
				       $this->site_url,
				       $this->site_name
				       );
    }
    $vcal .= $this->vcal_end();
    return $vcal;
  }
}
?>