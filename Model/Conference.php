<?php
App::uses('AppModel', 'Model');


class CcData extends AppModel {

  var $name = 'CcData';
  var $useTable = false;
  var $belongsTo = array('Conference');
  var $_schema = array(
		       'from' => array('type'=>'string', 'length'=>100), 
		       'to' => array('type'=>'string', 'length'=>255), 
		       'subject' => array('type'=>'string', 'length'=>255), 
		       'body' =>array('type'=>'text')
    );

  var $validate = array(
			'from' => array(
					'rule'=>'notEmpty', 
					'message'=>'Please supply a valid from address.' ),
			'to' => array(
				      'rule'=>'multiEmail', 
				      'message'=>'Please supply a comma-separated list of valid email addresses.'
				      ),
			'subject' => array(
					 'rule'=>'notEmpty', 
					 'message'=>'Please supply a subject.' ),
			'body' => array(
					   'rule'=>array('minLength', 1), 
					   'message'=>'Email body is required.  If you do not want to forward this announcement, leave the To: field blank.' )
			);
  // duplicates multiEmail function below
  function multiEmail($check) {
    $email_list = split(',',$check['to']);
    $V = new Validation();
    foreach ($email_list as $email) {
      if (!$V->email(trim($email))) {
	return false;
      }
    }
    return true;
  }
}




/**
 * Conference Model
 *
 */
class Conference extends AppModel {

  public $displayField = 'title';
  public $name = 'Conference';

  public $validate = array(
			   'title' => array(
			  		    'rule' => 'notEmpty'
					   ),
			'start_date' => array(
					      'rule' => 'date',
					      'message' => 'Please supply a valid date in yyyy-mm-dd format.'
					      ),
			'end_date' => array(
					    'rule' => 'date',
					    'message' => 'Please supply a valid date in yyyy-mm-dd format.'
					    ),
			//'institution' => array(
			//'rule' => 'notEmpty',
			//'message' => 'testing institution'
			//),
			'city' => array(
					'rule' => 'notEmpty',
					'message' => 'Please supply a city (or closest city).'
					),
			'country' => array(
					   'rule-1' => array(
							     'rule' => array('notEqualTo','country'),
							     'message' => 'Please select a country. (1)'
							     ),
					   'rule-2' => array(
							     'rule' => 'notEmpty',
							     'message' => 'Please select a country. (2)'
							     )
					   ),
			//'meeting_type' => array(
			//'rule' => 'notEmpty'
			//),
			//'subject_area' => array(
			//'rule' => 'notEmpty'
			//),

			'homepage' => array(
					    'rule' => array('url',true),
					    'message' => 'Please supply a valid and complete url.'
					    ),
			//'contact_name' => array(
			//'rule' => 'alphaNumeric',
			//'message' => 'Please supply a contact name.'
			//),
			'contact_email' => array(
						 'rule' => 'multiEmail',
						 'message' => 'Please supply a comma-separated list of valid email address; these will never be displayed publicly.'
						 ),
			//'description' => array(
			//'rule' => 'notEmpty'
			//),
			'captcha' => array(
					   'rule' => 'notEmpty',
			//'message' => 'This value must be the string "hopf".'
					   ),
			'report_comment' => array('rule' => 'notEmpty'),
			);

  public function notEqualTo($input,$value) {
    $input_values = array_values($input);
    return ((bool) strcmp($input_values[0],$value));
  }

  public function beforeSave($options = array()) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
    $this->data['Conference']['edit_key'] = substr( str_shuffle( $chars ), 0, 8);
    // zero pad day and month
    try{
      $sdo = new DateTime($this->data['Conference']['start_date']);	
    }
    catch (Exception $e) {
      $this->invalidate('start_date',$e->getMessage());
      return false;
    }
    try{
      $edo = new DateTime($this->data['Conference']['end_date']);	
    }
    catch (Exception $e) {
      $this->invalidate('end_date',$e->getMessage());
      return false;
    }
    $this->data['Conference']['start_date'] = $sdo->format('Y-m-d');
    $this->data['Conference']['end_date'] = $edo->format('Y-m-d');
    if(strcmp($this->data['Conference']['end_date'],$this->data['Conference']['start_date']) < 0) {
      $this->invalidate('end_date','End date must follow start date.');
      return false;
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

  public $hasAndBelongsToMany = array(
	 'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'conferences_tags',
			'foreignKey' => 'conference_id',
			'associationForeignKey' => 'tag_id',
			'unique' => 'keepExisting',
			/*
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			*/
			'with'=>'ConferencesTag'
			)
				      );
  
}
