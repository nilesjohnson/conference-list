<?php
/* /app/views/helpers/ical.php */
class GcalHelper extends AppHelper {
  public function __construct(View $view, $settings = array()) {
    parent::__construct($view, $settings);
    $site_url = Configure::read('site.home');
    $site_name = Configure::read('site.name');
    //debug($settings);
  }
  

  public function gcal_url($id, $start_date, $end_date, $title, $city, $country, $url) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $Gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&".
      "text=".urlencode($title)."&".
      "dates=".$start_string."/".$end_string.
      "&details=".$url.
      "&location=".urlencode($location).
      "&trp=false&sprop=".urlencode($this->site_url).
      "&sprop=name:".urlencode($this->site_name);
    return $Gcal_url;
  }

  public function gcal($conference) {
    return $this->gcal_url($conference['id'], 
			   $conference['start_date'], 
			   $conference['end_date'],
			   $conference['title'],
			   $conference['city'],
			   $conference['country'],
			   $conference['homepage']
			   );

  }
}
?>