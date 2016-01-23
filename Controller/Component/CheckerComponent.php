<?php
App::uses('Component', 'Controller');
class CheckerComponent extends Component {  

  public function conferenceValid($confdata) {
    //$this->loadModel('Conference');
    $conf=ClassRegistry::init('Conference');
    if (!($conf->validates($confdata))) {
      //debug($this->Conference->validationErrors); //displays array info
      foreach (Set::flatten($conf->validationErrors) as $field => $message) {
	//debug("field: ".$field." message: ".$message);
	$conf->invalidate($field,$message);
      }
      return false;
    }
    else {
      return true;
    }
  }
	
  public function tagValid($tagdata){
    $tag=ClassRegistry::init('Tag');
    if (!($tag->tagsValidator($tagdata))) {
      //debug($this->Tag->invalidFields());
      $tagdata->invalidate('Tag','Please supply at least one subject tag.');
      return false;
    }
    else {
      return true;
    }
  }
}