<?php
  //App::uses('Utility/Inflector', 'View');

class DisplayHelper extends AppHelper {
  /*
  public function __construct(View $view, $settings = array()) {
    parent::__construct($view, $settings);
    //debug($settings);
  }
  */

  /*
  function gcal_url($id, $start_date, $end_date, $title, $city, $country, $url, $conflist_url,$conflist_name) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $Gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&".
      "text=".urlencode($title)."&".
      "dates=".$start_string."/".$end_string.
      "&details=".$url.
      "&location=".urlencode($location).
      "&trp=false&sprop=".urlencode($conflist_url).
      "&sprop=name:".urlencode($conflist_name);
    return $Gcal_url;
  }
  */
  public function asArray($conference_data) {
    $out_array = array();
    foreach ($conference_data as $key => $value) {
      if ($key != 'id' && $key != 'edit_key' && $key != 'contact_email') {
	$out_array[] = [$key,str_pad(__(Inflector::humanize($key)),17),$value];
      }
    }
    return $out_array;
  }

  public function asText($conference_data) {
    $output = '';
    foreach ($this->asArray($conference_data) as $entry) {
      $output .= $entry[1] . ': ' . $entry[2] . "\n";
    }
    return $output;
  }

}
?>