<?php
App::uses('AppModel', 'Model');



/**
 * Registrant Model
 *
 */
class Registrant extends AppModel {

  public $displayField = 'name';
  public $name = 'Registrant';
  /*  public $virtualFields = array(
				'first_name' => 
	"IF(
	LOCATE(' ', Registrant.name) > 0,
	SUBSTRING(Registrant.name, 1, LOCATE(' ', Registrant.name) - 1),
        Registrant.name
        )",
				'last_name' =>
        "IF(
        LOCATE(' ', Registrant.name) > 0,
        SUBSTRING(Registrant.name, LOCATE(' ', Registrant.name) + 1),
        NULL
        )",
				);
  */
  public $virtualFields = array(
				'name' => 'CONCAT(Registrant.first_name," ",Registrant.last_name)',
				);
  public $validate = array(
			   'name' => array(
					   'rule' => 'notEmpty'
						 ),
			   //'institution' => array(
			   //'rule' => 'notEmpty',
			   //'message' => 'testing institution'
			   //),
			   'webpage' => array(
					      'rule' => 'emptyOrUrl',
					      'message' => 'Please supply a valid url or leave blank.',
					      ),
			   'email' => array(
					    'rule' => 'email',
					    'message' => 'Please supply a valid email address; this will never be displayed publicly.'
					    ),
			   'captcha' => array(
					      'rule' => 'notEmpty',
					      ),
			   );

  public $hasAndBelongsToMany = array(
             'Conference' => array(
                        'className' => 'Conference',
                        'joinTable' => 'conferences_registrants',
                        'foreignKey' => 'registrant_id',
                       	'associationForeignKey' => 'conference_id',
                       	'unique' => 'keepExisting',
                       	/*
                       	'conditions' => '',
                       	'fields' => '',
                       	'order' => '',
                       	'limit' => '',
                       	'offset' => '',
                       	'finderQuery' => '',
                       	*/
                       	'with'=>'ConferencesRegistrant'
                                   )
                                      );



  function emptyOrUrl($input) {
    if (!$input['webpage']) {
      return true;
    }
    $V = new Validation();
    return $V->url($input['webpage']);
  }

  public function notEqualTo($input,$value) {
    $input_values = array_values($input);
    return ((bool) strcmp($input_values[0],$value));
  }

  public function beforeValidate($options = array()) {
    // split name into first and last
    $names = preg_split('/[\s]+/',$this->data['Registrant']['name']);
    $this->data['Registrant']['last_name'] = array_pop($names);
    $this->data['Registrant']['first_name'] = implode(' ',$names);
    return true; //this is required for validation to succeed
  }

  public function beforeSave($options = array()) {
    // add http:// if not present in webpage
    $webpage = $this->data['Registrant']['webpage'];
    $V = new Validation();
    if (!empty($webpage) && $V->url($webpage) && !$V->url($webpage,true)) {
      $this->data['Registrant']['webpage'] = 'http://'.$webpage;
    }
    
    // generate edit key
    if (empty($this->data['Registrant']['edit_key'])) {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
      $this->data['Registrant']['edit_key'] = substr( str_shuffle( $chars ), 0, 8);
    }
    return true;
  }

  public function multiEmail($check) {
    $email_list = preg_split("/[\s,]+/",$check['contact_email']);
    $V = new Validation();
    foreach ($email_list as $email) {
      if (!$V->email(trim($email))) {
	return false;
      }
    }
    return true;
  }


}
