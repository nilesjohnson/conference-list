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
  //var $hasOne = 'CcData';  // model for cc data

  var $months = array("none", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


  public $helpers = array('Js', 'Html', 'Text', 'Gcal', 'Display');

  public $components = array('Email', 'RequestHandler', 'Session', 'Paginator', 'MathCaptcha', 'Security', 'Cookie', 'Checker');

  //Regular ol' $this->paginate() ceases to function when this is declared, but this allows for pagination of different Models within same Controller
//and for some reason paginating Conferences gives an Internal Error on this... Not sure why
  /*	public $paginate = array(
		'Conference' => array (),
		'ConferencesTag'=>array()
	   );
	   */

  public function beforeFilter() {
    parent::beforeFilter(); //you're supposed to always have this, don't ask me why
    $this->Cookie->name = 'confList';
    $this->Cookie->time = '1 year';
    $this->Security->blackHoleCallback = 'blackhole';
  }

  public function blackhole($type) {
    CakeLog::write('debug','Blackholed request.  Session and conference data follow.');
    CakeLog::write('debug','Blackhole type: '.$type);
    CakeLog::write('debug','User Agent: '.print_r($this->Session->userAgent(),$return=true));

    if (!(empty($this->data))) {
      if (array_key_exists('Conference',$this->data)) {
	CakeLog::write('debug',"title: ".$this->data['Conference']['title']);
	CakeLog::write('debug',"contact_email: ".$this->data['Conference']['contact_email']);
	CakeLog::write('debug',"captcha: ".$this->data['Conference']['captcha']);
      }
      else {
	CakeLog::write('debug','No conference data.');
      }
    }
    if ($type == 'csrf') {
      throw new BadRequestException('CSRF token is either expired or corrupted.');
    }
    else {
      throw new BadRequestException('Unknown security error: request has been black-holed');
    }
  }

  public function index($sort_condition=Null) {
    $this->set('sort_text','Sort by: ');
    $this->set('view_title','Upcoming Meetings');
    $this->set('months', $this->months);
    $this->set('sort_condition',$sort_condition);
    // default sort conditions
    $order_array =  array('Conference.start_date' => 'asc',
			  'Conference.end_date' => 'asc',
			  'Conference.title' => 'asc'
			  //demons are invoked when using HABTM and Pagination (hence the manual join that has to take place)
			  //'Tag.name',
			  );
	
    $conditions=array();
    if (!isset($this->request->query['past'])) {
      $conditions = array ("Conference.end_date >" => date('Y-m-d', strtotime("-1 week")));
    }
    else {
      $this->set('view_title','All Meetings');
    }
    $display_options = array('conditions' => $conditions, 'order' => $order_array);    

    // remove tag validation so tags are not required
    $this->Conference->Tag->validator()->remove('Tag');
	
    // collect tags from post data
    // then extract the tags and put into array
    // either by Cookie or passed parameter
    $tagids=null;

    //first check if we're supposed to be deleting tags
    if (isset($this->request->query['t0'])){
      $this->Cookie->delete('tags');
      return $this->redirect(array('controller'=>null,'action' =>'/'));
    }
    $cookie=$this->Cookie->read('tags');
    //$index_link_array = array('controller' => 'conferences', 'action' => 'index');
    if (isset($this->params['tags']) || isset($cookie)) {
      if (isset($this->params['tags'])){
	$tags=explode('-', $this->params['tags']);
	$this->loadModel('Tag');
	$this->Tag->recursive=0;
	$tagids=array();
	foreach ($tags as $tag){
	  // get tag id numbers from names
	  $t=$this->Tag->find('first',array('conditions'=>array('Tag.name LIKE "'.$tag.'%"')));
	  //debug($t);
	  if ($t) {
	    array_push($tagids,$t['Tag']['id']);
	  }
	  else {
	    $this->Session->setFlash('unknown tag '.$tag,'FlashBad');
	  }
	}
      }
      else {
	$tagids=$cookie;
      }
      //recursve array to build nested 'OR' list
     $tagquery=array();
     $temp_array = &$tagquery;
     foreach ($tagids as $i => $item) {
	$temp_array = &$temp_array['OR'];
	$temp_array['ConferencesTag.tag_id'] =$item;
      }
      array_push($display_options['conditions'],$tagquery);
    }
	//setting a very low limit for testing
	$display_options['limit']=10;
	//manual join so aforementioned recursive array actually works
	$display_options['joins'] = array(
            array(
                'table' => 'conferences_tags',
                'alias' => 'ConferencesTag',
                'type' => 'LEFT OUTER',
                'conditions' => array("Conference.id = ConferencesTag.conference_id"),
            )
      );
	//so conferences with multiple tags do not repeat, also this seems the only way to fix paginator  
	$display_options['group']= array('ConferencesTag.conference_id');
	$this->paginate = $display_options;
	//$this->paginate['order'] = $order_array;
	//debug($this->paginate);
	$conferences=$this->Paginator->paginate();
    $tags=$this->Conference->Tag->find('list');
    $this->set(compact('conferences', 'tags', 'tagids'));

    // process RSS feed      
    if( $this->RequestHandler->isRss() ){
      $this->set(compact('conferences'));
    }
	
	if ($this->request->is('post')) {
      // read tags from form, or delete cookie
      if (isset($this->request->data['Tag']['Tag']) && !empty($this->request->data['Tag']['Tag'])){
	$tagnames=array();
	$this->loadModel('Tag',array('recursive'=>0));
	//$this->Tag->recursive=0;
	foreach ($this->request->data['Tag']['Tag'] as $tag){
	  // get tag names from id numbers
	  $t=$this->Tag->find('first',array('conditions'=>array('Tag.id'=>$tag)));
	  $t=explode('.',$t['Tag']['name']);
	  array_push($tagnames,$t[0]);
	}
	$tagstring=implode('-',$tagnames);
	//$this->Session->setFlash($tagstring,'FlashGood'); // for testing
	$this->Cookie->write('tags',$this->request->data['Tag']['Tag']);
	return $this->redirect(array('controller'=>null,'action' => $tagstring.'/', $sort_condition));
      }
      else {
	$this->Cookie->delete('tags');
	return $this->redirect(array('controller'=>null,'action' => '/'));
      }
    }
  }


  /*
  public function past_unused() {
    $order_array =  array('Conference.start_date',
			    'Conference.end_date',
			    'Conference.title',
			    );
    $find_array = array('order' => $order_array);    
    $this->set('conferences', $this->Conference->find('all', $find_array));

  }
  */

  /*
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
  */


  /*
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
  */
  
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


  public function gcal($id) {
    $this->Conference->id = $id;
    if (empty($this->data)) {
      $this->set('conference', $this->Conference->read());
      $this->request->data = $this->Conference->read();
    }

    $start_date = $this->data['Conference']['start_date'];
    $end_date = $this->data['Conference']['end_date'];
    $title = $this->data['Conference']['title'];
    $city = $this->data['Conference']['city'];
    $country = $this->data['Conference']['country'];
    $url = $this->data['Conference']['homepage'];
    $conflist_url = Configure::read('site.home');
    $conflist_name = Configure::read('site.name');

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


  /*
  public function sort_country_unused(){
    $this->set('conferences', $this->Conference->find('all',
						      array('order' => array(
									     'Conference.country',
									     'Conference.start_date',
									     'Conference.end_date',
									     'Conference.title',
									     ))));
  }



  */


  public function view($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->Conference->id = $id;
    $this->set('conference', $this->Conference->read());
  }


  public function add() {
    $this->set('countries',$this->loadCountries());
    $this->set('view_title', 'Add');
    //$this->loadModel('CcData');
    //not sure we even need this now
    $this->loadModel('Tag');
    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      $this->Conference->set($this->data);
      $this->Tag->set($this->data['Tag']);
	  
      //these don't really need separate variables but I did it anyway, feel free to include directly in IF statement
      $validconf=$this->Checker->conferenceValid($this->data['Conference']);
      $validtag=$this->Checker->tagValid($this->data['Tag']);
      //$this->ccdata = $this->data['CcData'];
      //$this->CcData->set($this->ccdata);


      // test whether conference and tag data validates

      // check for invalid conference data

      //debug($valid_data_2);

      // if conference and tag data validates, check for valid captcha
      if ($validtag && $validconf &&
	  $this->MathCaptcha->validates($this->data['Conference']['captcha'])) {
	// all good !
	$this->save_and_send();
      }
      // else: something invalid
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
    $tags=$this->Conference->ConferencesTag->Tag->find('list');
    $this->set(compact('tags'));
  }

  public function save_and_send() {
    /*
     * helper function to save data and send email
     * ends with redirect
     */
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
      $Email = $this->prepEmail();
      $Email->send();
      $this->Session->setFlash('Your conference information has been saved.  An email with edit/delete links has been sent to the contact address.', 'FlashGood');
      /*
	if ($this->ccdata['to'] != '') {
	$this->Session->setFlash('Your conference information has been saved.  An email with edit/delete links has been sent to the contact address, and a separate announcement has been sent to the given addresses.', 'FlashGood');
	}
      */
      $this->redirect(array('action' => 'index'));
    } 
    else {
      $this->Session->setFlash('There was an error saving the data','FlashBad');
    }
  }

  /*
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
  */

  public function prepEmail($id = null) {
    $Email = new CakeEmail();
    if (!is_null($id)) {
      $this->Conference->id = $id;
      if (!$this->Conference->exists($id)) {
	throw new NotFoundException(__('Invalid conference (3)'));
      }
      $this->data = $this->Conference->read();
    }
    $Email->viewVars(array('conference' => $this->data));
    $Email->template('default','default')
      ->emailFormat('text');
    $Email->from(array(Configure::read('site.host_email') => Configure::read('site.name')));
    $to_array = preg_split("/[\s,]+/",$this->data['Conference']['contact_email']);
    $Email->to($to_array);
    $Email->bcc(Configure::read('site.admin_email'));
    $Email->subject(Configure::read('site.name') . ": " . $this->data['Conference']['title']);
    if (!is_null($id)) {
      $this->set('conference',$this->data);
      $this->render('../Emails/text/default','Emails/text/default');
      return null;
    }
    return $Email;
  }

  public function edit($id = null, $key = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->Conference->id = $id;
    $this->loadModel('Tag');
    $this->set('countries',$this->loadCountries());
    $tags=$this->Conference->ConferencesTag->Tag->find('list');
    $this->set(compact('tags'));
    $this->set('edit',1);
    if (empty($this->data)) {
      $this->data = $this->Conference->read();
      $this->request->data['Conference']['passed_key'] = $key;
      //debug($this->data);

      if ($key != $this->data['Conference']['edit_key']) {
	$this->Session->SetFlash('Invalid edit key. (2)','FlashBad');
	$this->redirect(array('action' => 'index'));
      }
      //debug('rendering add');
      $this->render('add');
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

      if ($this->Checker->tagValid($this->data['Tag']) && $this->Conference->save($this->data)) {
	$this->request->data = $this->Conference->read();
	$Email = $this->prepEmail();
	$Email->send();

	$this->Session->setFlash('Your conference announcement has been updated.  An email with the new edit/delete links has been sent to the contact address.','FlashGood');
	$this->redirect(array('action' => 'index'));
      }
      else {
	$this->Session->setFlash('Please check for errors below.', 'FlashBad');
      }
    }
  }
  


  /*
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
  */

  public function delete($id = null) {
    $this->Conference->id = $id;
    if (!$this->Conference->exists()) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Conference->delete()) {
      $this->Session->setFlash('The conference announcement has been deleted.', 'FlashGood');
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
    $this->set('valid_admin',false);
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->Conference->id = $id;
    $this->set('conference', $this->Conference->read());
    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      if ($this->data['Admin']['admin_key'] == Configure::read('site.admin_key') || $this->data['Admin']['admin_key'] == $this->Conference->field('edit_key')) {
	  $this->set('valid_admin',true);
	}
    }
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


  /*
  public function admin_index() {
    $this->Conference->recursive = 0;
    $this->set('conferences', $this->Paginator->paginate());
  }

  public function admin_view($id,$key) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    if ($key != Configure::read('site.admin_key')) {
      throw new NotFoundException(__('Invalid admin key'));
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
  */

  public function loadCountries($file = "../webroot/files/countries/dist/countries.csv") {
    $tmpCountries = array();
    $tmpCountries['country'] =  "Country...";
    if (($handle = fopen($file, "r")) !== FALSE) {
      //setlocale(LC_CTYPE, "en.UTF16"); // for unicode; seems to be unnecessary
      $data0 = fgetcsv($handle, 1000, ";");
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
	$name = split(',',$data[0])[0];
	if (!array_key_exists($data[10],$tmpCountries)) {
	  $tmpCountries[$data[10]] = array();
	}
	// handle some common special cases
	if ($name == "United States") {
	  $tmpCountries[$data[10]]["USA"] = $name;
	}
	elseif ($name == "United Kingdom") {
	  $tmpCountries[$data[10]]["UK"] = $name;
	}
	else {
	  $tmpCountries[$data[10]][$name] = $name;
	}
        //echo "<p> $num fields in line $row: <br /></p>\n";
      }
      fclose($handle);
      return $tmpCountries;
    }
  }

  public $countries_NOTUSED = array(
			 "" => 'Country...', // value attribte of first element must be empty
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
