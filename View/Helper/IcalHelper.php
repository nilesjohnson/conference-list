<?php
/* /app/views/helpers/ical.php */
class IcalHelper extends AppHelper {

  function gcal_url($id, $start_date, $end_date, $title, $city, $country, $url) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $Gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&".
      "text=".$title."&".
      "dates=".$start_string."/".$end_string.
      "&details=".$url.
      "&location=".$location.
      "&trp=false&sprop=http%3A%2F%2Fwww.nilesjohnson.net%2Falgtop-conf&sprop=name:AlgTop-Conf";
    return $Gcal_url;
  }

  function vcal_string($id, $start_date, $end_date, $title, $city, $country, $url) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $vcal = "BEGIN:VCALENDAR\n".
      "VERSION:2.0\n".
      "BEGIN:VEVENT\n".
      "DTSTART:".$start_string."\n".
      "DTEND:".$end_string."\n".
      "LOCATION:".$location."\n".
      "SUMMARY:".$title."\n".
      "URL:".$url."\n".
      "END:VEVENT\n".
      "END:VCALENDAR";
    return $vcal;  
  }

}
?>