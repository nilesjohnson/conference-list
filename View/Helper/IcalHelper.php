<?php
/* /app/views/helpers/ical.php */
class IcalHelper extends AppHelper {
  public function __construct(View $view, $settings = array()) {
    parent::__construct($view, $settings);
    //debug($settings);
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



}
?>