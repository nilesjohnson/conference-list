<?php
App::uses('AppController', 'Controller');
/**
 * Conferences Controller
 *
 * @property Conference $Conference
 * @property PaginatorComponent $Paginator
 */

class ConferencesController extends AppController {


  var $name = 'Conferences';
  var $hasOne = 'CcData';  // model for cc data
  var $admin_email = array(
    'admin1@example.com', 
    'admin2@example.com', 
    'admin3@example.com'
  );

  var $months = array("none", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


  public $helpers = array('Js', 'Html', 'Ical', 'Text');

  public $components = array('Email', 'RequestHandler', 'Session', 'MathCaptcha', 'EmailKey');




  public function index($sort_condition=Null) {
    $this->set('sort_text','Sort by: ');
    $this->set('view_title','Upcoming Meetings');
    $this->set('months', $this->months);
    $this->set('sort_condition',$sort_condition);
    $conditions = array (
			 "Conference.end_date >" => date('Y-m-d', strtotime("-1 week"))
			 );
    if ($sort_condition == 'country') {
      // determine order_array and subsort function for this sort_condition
      $order_array =  array('Conference.country',
			    'Conference.start_date',
			    'Conference.end_date',
			    'Conference.title',
			    );
      $this->set('search_links', array('Date' => array('controller' => 'conferences', 'action' => 'index')));								   
    }
    else {
      // determine order_array and subsort function for default sort_condition
      $order_array =  array('Conference.start_date',
			    'Conference.end_date',
			    'Conference.title',
			    );
      $this->set('search_links', array('Country' => array('controller' => 'conferences', 'action' => 'index', 'country')));						       	
    }

    // find announcement items
    if ($sort_condition == 'all') {
      $this->set('sort_text','');
      $this->set('view_title','All Meetings');
      $conditions = array();
      $this->set('search_links', array('Main List' => array('controller' => 'conferences', 'action' => 'index')));
    }
    $find_array = array('conditions' => $conditions, 'order' => $order_array);    
    $this->set('conferences', $this->Conference->find('all', $find_array));

    // process RSS feed      
    if( $this->RequestHandler->isRss() ){
      $this->set(compact('conferences'));
    }
  }



  public function past() {
    $order_array =  array('Conference.start_date',
			    'Conference.end_date',
			    'Conference.title',
			    );
    $find_array = array('order' => $order_array);    
    $this->set('conferences', $this->Conference->find('all', $find_array));

  }



  function report($id = null) {
    $this->Conference->id = $id;
    if (empty($this->data)) {
      $this->set('conference', $this->Conference->read());
      $this->data = $this->Conference->read();
    } 
    else {
      if ($this->MathCaptcha->validates($this->data['Conference']['captcha'])) {
	if (empty($this->data['Conference']['report_comment'])){
	  $this->set('conference', $this->Conference->read());
	  $this->data = $this->Conference->read();
	  $this->Session->setFlash('Please include a comment', 'FlashBad');
	}
	else {
	  $report_comment = $this->data['Conference']['report_comment'];
	  $this->request->data = $this->Conference->read();
	  $this->request->data['Conference']['report_comment'] = $report_comment;
	  //$this->EmailKey->report_item($id,$this->data,$this->admin_email);
	  $this->Session->setFlash('Your comment has been reported; please allow a few days for action to be taken.', 'FlashGood');
	  $this->redirect(array('action'=>'index'));
	}
      }
      else {
	$this->set('conference', $this->Conference->read());	
	$this->request->data = $this->Conference->read();
	$this->Conference->invalidate('captcha','Please perform the indicated arithmetic.');
	$this->Session->setFlash('Please perform the indicated arithmetic before submitting the form.', 'FlashBad');
      }
    }
    $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
  }




  public function view_unused($id = null, $key = null) {
    $this->Conference->id = $id;
    if (empty($this->data)) {
      $this->set('conference', $this->Conference->read());
      $this->request->data = $this->Conference->read();
    } 
    else {
      if ($this->data['Conference']['edit_key'] != $this->Conference->field('edit_key')) {
	$this->Session->SetFlash('Invalid edit key.','FlashBad');
	$this->redirect(array('action' => 'index'));
      }
      if ($this->MathCaptcha->validates($this->data['Conference']['captcha'])) {
	$this->Conference->delete($id);
	$this->Session->setFlash('The conference announcement has been deleted.', 'FlashGood');
	$this->redirect(array('action'=>'index'));
      }
      else {
	$this->set('conference', $this->Conference->read());
	$this->request->data = $this->Conference->read();
	$this->Conference->invalidate('captcha','Please perform the indicated arithmetic.');
	$this->Session->setFlash('Please perform the indicated arithmetic before submitting the form.', 'FlashBad');
      }
    }
    $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
    if ($key != $this->data['Conference']['edit_key']) {
      $this->Session->SetFlash('Invalid edit key.','FlashBad');
      $this->redirect(array('action' => 'index'));
    }
  }

  
  public function ical($id=null) {
    $this->Conference->id = $id;
    if (empty($this->data)) {
      $this->set('conference', $this->Conference->read());
      $this->request->data = $this->Conference->read();
    }
    $vcal = $this->vcal_string($this->data['Conference']['id'], 
					    $this->data['Conference']['start_date'], 
					    $this->data['Conference']['end_date'], 
					    $this->data['Conference']['title'], 
					    $this->data['Conference']['city'], 
					    $this->data['Conference']['country'], 
					    $this->data['Conference']['homepage']
					    );
    //$this->set('vcal',$vcal);
    $this->response->body($vcal);
    $this->response->type('ics');
    $this->response->download('announcement_'.$id.'.ics');
    return $this->response;
  }

  public function vcal_string($id, $start_date, $end_date, $title, $city, $country, $url) {
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



  public function sort_country(){
    $this->set('conferences', $this->Conference->find('all',
						      array('order' => array(
									     'Conference.country',
									     'Conference.start_date',
									     'Conference.end_date',
									     'Conference.title',
									     ))));
  }






  public function view($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $options = array('conditions' => array('Conference.' . $this->Conference->primaryKey => $id));
    $this->set('conference', $this->Conference->find('first', $options));
  }


  public function add() {
    $this->set('countries',$this->countries);
    $this->set('view_title', 'Add');
    $this->loadModel('CcData');
    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      $this->Conference->set($this->data);
      $this->ccdata = $this->data['CcData'];
      $this->CcData->set($this->ccdata);


      // test whether conference and cc data validates
      $valid_data = true;
      // check for invalid conference data
      if (!($this->Conference->validates($this->data['Conference']))) {
	//debug($this->Conference->invalidFields()); //displays array info
	foreach ($this->Conference->invalidFields() as $field => $message) {
	  $this->Conference->invalidate($field,$message);
	}
	$this->Session->setFlash('Please check for errors below.', 'FlashBad');
	$valid_data = false;
      }      
      // when cc To: field nonempty, check for invalid cc data
      if ($this->ccdata['to'] != '' && !($this->CcData->validates($this->ccdata))) {
	//debug($this->CcData->invalidFields());  //displays array info
	foreach ($this->CcData->invalidFields() as $field => $message) {
	  $this->CcData->invalidate($field,$message);
	}
	$this->Session->setFlash('Please check for errors below.', 'FlashBad');
	$valid_data = false;
      }	
      
      // if conference and cc data validates, check for valid captcha
      if ($valid_data && $this->MathCaptcha->validates($this->data['Conference']['captcha'])) {

	// change any 2-digit years in start/end dates to 4-digit years
	$D = array('start_date','end_date');
	foreach ($D as $d) {
	  if (preg_match('/^\d\d-/',$this->data['Conference'][$d])) {
	    $this->request->data['Conference'][$d] = '20'.$this->data['Conference'][$d];
	  }
	}
	
	// verify that all data saves, and send email(s)
	if ($this->Conference->save($this->data)) {
	  $this->request->data = $this->Conference->read();
	  //$this->EmailKey->send_key($this->Conference->id, $this->data, $this->admin_email);
	  $this->Session->setFlash('Your conference information has been saved.  An email with edit/delete links has been sent to the contact address.', 'FlashGood');
	  if ($this->ccdata['to'] != '') {
	    //$this->EmailKey->send_cc($this->ccdata, $this->admin_email);
	    $this->Session->setFlash('Your conference information has been saved.  An email with edit/delete links has been sent to the contact address, and a separate announcement has been sent to the given addresses.', 'FlashGood');
	  }
	  $this->redirect(array('action' => 'index'));
	}
      }
      else {
	$this->Conference->invalidate('captcha','Please perform the indicated arithmetic.');
	$this->Session->setFlash('Please check for errors below.', 'FlashBad');
      }
    }

    $defaults = array('subject_area' => 'algebraic topology',
		      'meeting_type' => 'conference',
		      'homepage' => 'http://',
		      );
    foreach ($defaults as $key => $value) {
      if (empty($this->data['Conference'][$key])) {
	$this->request->data['Conference'][$key] = $value;
      }
    }
    $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
  }




  public function add_baked() {
    if ($this->request->is('post')) {
      $this->Conference->create();
      if ($this->Conference->save($this->request->data)) {
        $this->Session->setFlash(__('The conference has been saved.'));
        return $this->redirect(array('action' => 'index'));
      } 
      else {
        $this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
      }
    }
  }


  public function edit($id = null, $key = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->Conference->id = $id;
    $this->set('countries',$this->countries);
    if (empty($this->data)) {
      $this->data = $this->Conference->read();
      $this->request->data['Conference']['passed_key'] = $key;
      //debug($this->data);

      if ($key != $this->data['Conference']['edit_key']) {
	$this->Session->SetFlash('Invalid edit key. (2)','FlashBad');
	$this->redirect(array('action' => 'index'));
      }
    } 
    else {
      // check that given key matches key from database
      $prev = $this->Conference->find('first', array(
          'conditions' => array('Conference.id' => $id)
      ));
      if ($key != $prev['Conference']['edit_key']) {
        $this->Session->SetFlash('Invalid edit key. (1)','FlashBad');
        $this->redirect(array('action' => 'index'));
      }
      if ($this->Conference->save($this->data)) {
	$this->request->data = $this->Conference->read();
	//$this->EmailKey->send_key($this->Conference->id,$this->data,$this->admin_email);
	$this->Session->setFlash('Your conference announcement has been updated.  An email with the new edit/delete links has been sent to the contact address.','FlashGood');
	$this->redirect(array('action' => 'index'));
      }
    }
  }
  



  public function edit_baked($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    if ($this->request->is(array('post', 'put'))) {
      if ($this->Conference->save($this->request->data)) {
        $this->Session->setFlash(__('The conference has been saved.'));
        return $this->redirect(array('action' => 'index'));
      }
      else {
        $this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
      }
    } 
    else {
      $options = array('conditions' => array('Conference.' . $this->Conference->primaryKey => $id));
      $this->request->data = $this->Conference->find('first', $options);
    }
  }


  public function delete($id = null) {
    $this->Conference->id = $id;
    if (!$this->Conference->exists()) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Conference->delete()) {
      $this->Session->setFlash(__('The conference has been deleted.'));
    }
    else {
      $this->Session->setFlash(__('The conference could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
  }


  public function about() {
    $this->set('view_title','About');
  }


  public function admin($id) {
    $this->set('key_code',"**********");
    $this->Conference->id = $id;
    $this->set('conference', $this->Conference->read());
    /*
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.";
    $key_array = str_split($this->Conference->field('edit_key'));
    $shift_array = array(18,3,-12,24,-5,-7,2,21);
    $i = 0;
    foreach ($key_array as $l) {
      $key_code_array[] = (strpos($chars,$l) + $shift_array[$i]) % 62;
      $i = $i+1;
    }
    $this->set('key_code','['.implode(',',$key_code_array).']');
    //$this->set('key_code', $this->Conference->field('edit_key'));
    */
  }





  public function admin_index() {
    $this->Conference->recursive = 0;
    $this->set('conferences', $this->Paginator->paginate());
  }

  public function admin_view($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $options = array('conditions' => array('Conference.' . $this->Conference->primaryKey => $id));
    $this->set('conference', $this->Conference->find('first', $options));
  }

  public function admin_add() {
    if ($this->request->is('post')) {
      $this->Conference->create();
      if ($this->Conference->save($this->request->data)) {
        $this->Session->setFlash(__('The conference has been saved.'));
        return $this->redirect(array('action' => 'index'));
      }
      else {
        $this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
      }
    }
  }

  public function admin_edit($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    if ($this->request->is(array('post', 'put'))) {
      if ($this->Conference->save($this->request->data)) {
        $this->Session->setFlash(__('The conference has been saved.'));
        return $this->redirect(array('action' => 'index'));
      }
      else {
        $this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
      }
    }
    else {
      $options = array('conditions' => array('Conference.' . $this->Conference->primaryKey => $id));
      $this->request->data = $this->Conference->find('first', $options);
    }
  }

  public function admin_delete($id = null) {
    $this->Conference->id = $id;
    if (!$this->Conference->exists()) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Conference->delete()) {
      $this->Session->setFlash(__('The conference has been deleted.'));
    }
    else {
      $this->Session->setFlash(__('The conference could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
  }


  public $countries = array(
			 "country" => 'Country...',
			 "Afganistan" => 'Afghanistan',
			 "Albania" => 'Albania',
			 "Algeria" => 'Algeria',
			 "American Samoa" => 'American Samoa',
			 "Andorra" => 'Andorra',
			 "Angola" => 'Angola',
			 "Anguilla" => 'Anguilla',
			 "Antigua &amp; Barbuda" => 'Antigua & Barbuda',
			 "Argentina" => 'Argentina',
			 "Armenia" => 'Armenia',
			 "Aruba" => 'Aruba',
			 "Australia" => 'Australia',
			 "Austria" => 'Austria',
			 "Azerbaijan" => 'Azerbaijan',
			 "Bahamas" => 'Bahamas',
			 "Bahrain" => 'Bahrain',
			 "Bangladesh" => 'Bangladesh',
			 "Barbados" => 'Barbados',
			 "Belarus" => 'Belarus',
			 "Belgium" => 'Belgium',
			 "Belize" => 'Belize',
			 "Benin" => 'Benin',
			 "Bermuda" => 'Bermuda',
			 "Bhutan" => 'Bhutan',
			 "Bolivia" => 'Bolivia',
			 "Bonaire" => 'Bonaire',
			 "Bosnia &amp; Herzegovina" => 'Bosnia & Herzegovina',
			 "Botswana" => 'Botswana',
			 "Brazil" => 'Brazil',
			 "British Indian Ocean Ter" => 'British Indian Ocean Ter',
			 "Brunei" => 'Brunei',
			 "Bulgaria" => 'Bulgaria',
			 "Burkina Faso" => 'Burkina Faso',
			 "Burundi" => 'Burundi',
			 "Cambodia" => 'Cambodia',
			 "Cameroon" => 'Cameroon',
			 "Canada" => 'Canada',
			 "Canary Islands" => 'Canary Islands',
			 "Cape Verde" => 'Cape Verde',
			 "Cayman Islands" => 'Cayman Islands',
			 "Central African Republic" => 'Central African Republic',
			 "Chad" => 'Chad',
			 "Channel Islands" => 'Channel Islands',
			 "Chile" => 'Chile',
			 "China" => 'China',
			 "Christmas Island" => 'Christmas Island',
			 "Cocos Island" => 'Cocos Island',
			 "Colombia" => 'Colombia',
			 "Comoros" => 'Comoros',
			 "Congo" => 'Congo',
			 "Cook Islands" => 'Cook Islands',
			 "Costa Rica" => 'Costa Rica',
			 "Cote DIvoire" => "Cote D'Ivoire",
			 "Croatia" => 'Croatia',
			 "Cuba" => 'Cuba',
			 "Curaco" => 'Curacao',
			 "Cyprus" => 'Cyprus',
			 "Czech Republic" => 'Czech Republic',
			 "Denmark" => 'Denmark',
			 "Djibouti" => 'Djibouti',
			 "Dominica" => 'Dominica',
			 "Dominican Republic" => 'Dominican Republic',
			 "East Timor" => 'East Timor',
			 "Ecuador" => 'Ecuador',
			 "Egypt" => 'Egypt',
			 "El Salvador" => 'El Salvador',
			 "Equatorial Guinea" => 'Equatorial Guinea',
			 "Eritrea" => 'Eritrea',
			 "Estonia" => 'Estonia',
			 "Ethiopia" => 'Ethiopia',
			 "Falkland Islands" => 'Falkland Islands',
			 "Faroe Islands" => 'Faroe Islands',
			 "Fiji" => 'Fiji',
			 "Finland" => 'Finland',
			 "France" => 'France',
			 "French Guiana" => 'French Guiana',
			 "French Polynesia" => 'French Polynesia',
			 "French Southern Ter" => 'French Southern Ter',
			 "Gabon" => 'Gabon',
			 "Gambia" => 'Gambia',
			 "Georgia" => 'Georgia',
			 "Germany" => 'Germany',
			 "Ghana" => 'Ghana',
			 "Gibraltar" => 'Gibraltar',
			 "Great Britain" => 'Great Britain',
			 "Greece" => 'Greece',
			 "Greenland" => 'Greenland',
			 "Grenada" => 'Grenada',
			 "Guadeloupe" => 'Guadeloupe',
			 "Guam" => 'Guam',
			 "Guatemala" => 'Guatemala',
			 "Guinea" => 'Guinea',
			 "Guyana" => 'Guyana',
			 "Haiti" => 'Haiti',
			 "Hawaii" => 'Hawaii',
			 "Honduras" => 'Honduras',
			 "Hong Kong" => 'Hong Kong',
			 "Hungary" => 'Hungary',
			 "Iceland" => 'Iceland',
			 "India" => 'India',
			 "Indonesia" => 'Indonesia',
			 "Iran" => 'Iran',
			 "Iraq" => 'Iraq',
			 "Ireland" => 'Ireland',
			 "Isle of Man" => 'Isle of Man',
			 "Israel" => 'Israel',
			 "Italy" => 'Italy',
			 "Jamaica" => 'Jamaica',
			 "Japan" => 'Japan',
			 "Jordan" => 'Jordan',
			 "Kazakhstan" => 'Kazakhstan',
			 "Kenya" => 'Kenya',
			 "Kiribati" => 'Kiribati',
			 "Korea North" => 'Korea North',
			 "Korea South" => 'Korea South',
			 "Kuwait" => 'Kuwait',
			 "Kyrgyzstan" => 'Kyrgyzstan',
			 "Laos" => 'Laos',
			 "Latvia" => 'Latvia',
			 "Lebanon" => 'Lebanon',
			 "Lesotho" => 'Lesotho',
			 "Liberia" => 'Liberia',
			 "Libya" => 'Libya',
			 "Liechtenstein" => 'Liechtenstein',
			 "Lithuania" => 'Lithuania',
			 "Luxembourg" => 'Luxembourg',
			 "Macau" => 'Macau',
			 "Macedonia" => 'Macedonia',
			 "Madagascar" => 'Madagascar',
			 "Malaysia" => 'Malaysia',
			 "Malawi" => 'Malawi',
			 "Maldives" => 'Maldives',
			 "Mali" => 'Mali',
			 "Malta" => 'Malta',
			 "Marshall Islands" => 'Marshall Islands',
			 "Martinique" => 'Martinique',
			 "Mauritania" => 'Mauritania',
			 "Mauritius" => 'Mauritius',
			 "Mayotte" => 'Mayotte',
			 "Mexico" => 'Mexico',
			 "Midway Islands" => 'Midway Islands',
			 "Moldova" => 'Moldova',
			 "Monaco" => 'Monaco',
			 "Mongolia" => 'Mongolia',
			 "Montserrat" => 'Montserrat',
			 "Morocco" => 'Morocco',
			 "Mozambique" => 'Mozambique',
			 "Myanmar" => 'Myanmar',
			 "Nambia" => 'Nambia',
			 "Nauru" => 'Nauru',
			 "Nepal" => 'Nepal',
			 "Netherland Antilles" => 'Netherland Antilles',
			 "Netherlands" => 'Netherlands (Holland, Europe)',
			 "Nevis" => 'Nevis',
			 "New Caledonia" => 'New Caledonia',
			 "New Zealand" => 'New Zealand',
			 "Nicaragua" => 'Nicaragua',
			 "Niger" => 'Niger',
			 "Nigeria" => 'Nigeria',
			 "Niue" => 'Niue',
			 "Norfolk Island" => 'Norfolk Island',
			 "Norway" => 'Norway',
			 "Oman" => 'Oman',
			 "Pakistan" => 'Pakistan',
			 "Palau Island" => 'Palau Island',
			 "Palestine" => 'Palestine',
			 "Panama" => 'Panama',
			 "Papua New Guinea" => 'Papua New Guinea',
			 "Paraguay" => 'Paraguay',
			 "Peru" => 'Peru',
			 "Phillipines" => 'Philippines',
			 "Pitcairn Island" => 'Pitcairn Island',
			 "Poland" => 'Poland',
			 "Portugal" => 'Portugal',
			 "Puerto Rico" => 'Puerto Rico',
			 "Qatar" => 'Qatar',
			 "Republic of Montenegro" => 'Republic of Montenegro',
			 "Republic of Serbia" => 'Republic of Serbia',
			 "Reunion" => 'Reunion',
			 "Romania" => 'Romania',
			 "Russia" => 'Russia',
			 "Rwanda" => 'Rwanda',
			 "St Barthelemy" => 'St Barthelemy',
			 "St Eustatius" => 'St Eustatius',
			 "St Helena" => 'St Helena',
			 "St Kitts-Nevis" => 'St Kitts-Nevis',
			 "St Lucia" => 'St Lucia',
			 "St Maarten" => 'St Maarten',
			 "St Pierre &amp; Miquelon" => 'St Pierre & Miquelon',
			 "St Vincent &amp; Grenadines" => 'St Vincent & Grenadines',
			 "Saipan" => 'Saipan',
			 "Samoa" => 'Samoa',
			 "Samoa American" => 'Samoa American',
			 "San Marino" => 'San Marino',
			 "Sao Tome &amp; Principe" => 'Sao Tome & Principe',
			 "Saudi Arabia" => 'Saudi Arabia',
			 "Senegal" => 'Senegal',
			 "Seychelles" => 'Seychelles',
			 "Sierra Leone" => 'Sierra Leone',
			 "Singapore" => 'Singapore',
			 "Slovakia" => 'Slovakia',
			 "Slovenia" => 'Slovenia',
			 "Solomon Islands" => 'Solomon Islands',
			 "Somalia" => 'Somalia',
			 "South Africa" => 'South Africa',
			 "Spain" => 'Spain',
			 "Sri Lanka" => 'Sri Lanka',
			 "Sudan" => 'Sudan',
			 "Suriname" => 'Suriname',
			 "Swaziland" => 'Swaziland',
			 "Sweden" => 'Sweden',
			 "Switzerland" => 'Switzerland',
			 "Syria" => 'Syria',
			 "Tahiti" => 'Tahiti',
			 "Taiwan" => 'Taiwan',
			 "Tajikistan" => 'Tajikistan',
			 "Tanzania" => 'Tanzania',
			 "Thailand" => 'Thailand',
			 "Togo" => 'Togo',
			 "Tokelau" => 'Tokelau',
			 "Tonga" => 'Tonga',
			 "Trinidad &amp; Tobago" => 'Trinidad & Tobago',
			 "Tunisia" => 'Tunisia',
			 "Turkey" => 'Turkey',
			 "Turkmenistan" => 'Turkmenistan',
			 "Turks &amp; Caicos Is" => 'Turks & Caicos Is',
			 "Tuvalu" => 'Tuvalu',
			 "Uganda" => 'Uganda',
			 "Ukraine" => 'Ukraine',
			 "United Arab Erimates" => 'United Arab Emirates',
			 "UK" => 'United Kingdom',
			 "USA" => 'United States of America',
			 "Uraguay" => 'Uruguay',
			 "Uzbekistan" => 'Uzbekistan',
			 "Vanuatu" => 'Vanuatu',
			 "Vatican City State" => 'Vatican City State',
			 "Venezuela" => 'Venezuela',
			 "Vietnam" => 'Vietnam',
			 "Virgin Islands (Brit)" => 'Virgin Islands (Brit)',
			 "Virgin Islands (USA)" => 'Virgin Islands (USA)',
			 "Wake Island" => 'Wake Island',
			 "Wallis &amp; Futana Is" => 'Wallis & Futana Is',
			 "Yemen" => 'Yemen',
			 "Zaire" => 'Zaire',
			 "Zambia" => 'Zambia',
			 "Zimbabwe" => 'Zimbabwe',
			 );

}
