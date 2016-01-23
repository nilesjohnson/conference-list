<?php
  //App::uses('Utility/Inflector', 'View');

class DisplayHelper extends AppHelper {
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