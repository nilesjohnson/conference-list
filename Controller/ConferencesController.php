<?php
App::uses('AppController', 'Controller');
CakePlugin::load('Recaptcha');
/**
 * Conferences Controller
 *
 * @property Conference $Conference
 * @property PaginatorComponent $Paginator
 */


class ConferencesController extends AppController {


  var $name = 'Conferences';

  var $months = array("none", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

  //public $uses = array('Conferences');

  public $helpers = array('Js', 'Html', 'Text', 'Gcal', 'Ical', 'Display');

  public $components = array('Email', 'RequestHandler', 'Session', 'Paginator', 'Recaptcha.Recaptcha', 'Security', 'Checker','Cookie');
  
  //Regular ol' $this->paginate() ceases to function when this is declared, but this allows for pagination of different Models within same Controller

  public $paginate = array(
			   'Conference' => array (),
			   'ConferencesTag'=>array()
			   );


  public function beforeFilter() {
    parent::beforeFilter(); //you're supposed to always have this, don't ask me why
    $this->loadModel('Tag');
    $this->Tag->recursive=0;
    $this->set('tagstring','');
    $this->set('tagids',array());
    $this->Security->csrfCheck = false;
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
      throw new BadRequestException('CSRF token is either expired or corrupted.  The CSRF token is a browser cookie which prevents certain types of web form abuse.  This cookie expires on use, and must be set for you to submit forms on this site.',500);
    }
    else {
      throw new BadRequestException('Unknown security error: request has been black-holed');
    }
  }

  public function index($tagstring = null) {
    $this->set('view_title','Upcoming Meetings');
    $this->render_list(array('tagstring' => $tagstring,
			     'conditions' => array (
						    "Conference.end_date >" => date('Y-m-d', strtotime("-1 week"))),
			     ));
  }
  public function search($tagstring = null) {
    $this->set('search',1);
    $this->set('results',0);
    $this->set('view_title','Search Announcements');
    $this->set('countries',$this->loadCountries());

    $conditions = array();
    if (!empty($this->data)) {
      $this->set('results',1);
      foreach ($this->data['Search'] as $field => $value) {
	if ($value != '') {
	  if ($field == 'before') {
	    $conditions['start_date <'] = $value;
	  }
	  elseif ($field == 'after') {
	    $conditions['start_date >'] = $value;
	  }
	  elseif ($field == 'Tag') {
	    $tagarray = array();
	    foreach ($this->data['Search']['Tag'] as $t) {
	      array_push($tagarray,explode('.',$this->tag_name_from_id($t))[0]);
	    }
	    $tagstring = implode('-',$tagarray);
	  }
	  else {
	    $conditions[$field.' LIKE'] = '%'.$value.'%';
	  }
	}
      }  
    }
    //else: no data; render search form
    else {
      $conditions = array('start_date <' => '0');
      //$tagstring = null;
    }


    if (isset($tagstring)) {
      //debug($tagstring);
      $this->set('tagstring',$tagstring);
      $tagids=$this->tag_ids_from_names(explode('-', $tagstring));
      $this->set('tagids',$tagids);
    } 
    else {
      $this->set('tagstring','');
      $this->set('tagids',array());
    }


    $this->render_list(array('tagstring' => $tagstring,
			     'conditions' => $conditions,
			     ));
    $this->render('index'); // use the index view
  }
  

  public function render_list($args) {
    /*
      This is the function which renders our announcement list.
      By separating it into a separate function, we keep the 
      arguments for the main index simple, but allow other functions
      with more complex arguments to use the same rendering functionality.
     */
    //debug($args);
    $tagstring = $args['tagstring'];
    $conditions = $args['conditions'];
    $this->set('sort_text','Sort by: ');
    $this->set('months', $this->months);
    $this->set('sort_condition',null);
    // default sort conditions
    $order_array =  array('Conference.start_date',
			  'Conference.end_date',
			  'Conference.title',
			  'Tag.name',
			  );
    $display_options = array('conditions' => $conditions, 'order' => $order_array);    

    // remove tag validation so tags are not required
    $this->Conference->Tag->validator()->remove('Tag');
	
    $tagids=null;

    $index_link_array = array('controller' => 'conferences', 'action' => 'index');
    if (isset($this->params['tags']) || isset($tagstring)) {
      //debug($this->params['tags']);
      //debug($tagstring);
      $tagstring = $this->params['tags'] ? $this->params['tags'] : $tagstring;
      $tagids=$this->tag_ids_from_names(explode('-', $tagstring));

      $tagquery=array();
      $temp_array = &$tagquery;
      foreach ($tagids as $i => $item) {
	$temp_array = &$temp_array['OR'];
	$temp_array['ConferencesTag.tag_id'] =$item;
      }
      array_push($display_options['conditions'],$tagquery);
      $active_model = $this->Conference->ConferencesTag;
      $regroup = true;
    }
    else {
      $tagstring = '';
      $tagids = array();
      $active_model = $this->Conference->ConferencesTag;
      $regroup = false;
    }


    //debug($display_options);
    $conferencesTagsRaw = $active_model->find('all', $display_options);

    // do manual regrouping
    // surely this could be done more effeciently by
    // some kind of join and sql GROUP BY . . . but I couldn't
    // figure out how.
    $conferences = array();
    $conferencesTags = array();
    $prev_id = -1;
    //debug($conferencesTagsRaw);
    foreach ($conferencesTagsRaw as $ct) {
      // we are using the fact that we can find duplicate conferences
      // by checking ids of previous entries
      // because in this array entries with the same conference data
      // will be next to eachother
      $id = $ct['Conference']['id'];
      if ($id != $prev_id) {
	array_push($conferences,$ct['Conference']);
	$conferencesTags[$id] = array();
	$tagsForThisConference = $this->Conference->ConferencesTag->find('all',
									 array('conditions' => array('ConferencesTag.conference_id' => $id),
									       'fields' => array('Tag.id','Tag.name')));
	foreach ($tagsForThisConference as $item) {
	  array_push($conferencesTags[$id],$item['Tag']);
	}
	$prev_id = $id;
      }
    }

    //remove edit_key and contact_email in all index views
    $conferences = $this->unset_sensitive($conferences);


    $this->set('conferences', $conferences);
    $this->set('conferencesTags',$conferencesTags);

    $tags=$this->Conference->Tag->find('list');
	
    $this->set(compact('conferences', 'tags', 'tagstring', 'tagids'));

    $this->set('_serialize', array('conferences')); // variables that need to be serialized (for json or xml)
    // process requests for RSS, JSON, XML, and anything else with extenson
    if( isset($this->request->params['ext'])) {
      $this->set(compact('conferences'));
    }
  }

  public function unset_sensitive($confarray) {
    $outarray = array();
    foreach ($confarray as $c) {
      unset($c['edit_key']);
      unset($c['contact_email']);
      array_push($outarray,$c);
    }
    return $outarray;
  }

  public function tag_name_from_id($tagid) {
    $t = $this->Tag->find('first',array('conditions'=>array('Tag.id'=>$tagid)));
    return $t['Tag']['name'];
  }

  public function tag_ids_from_names($tagnames) { 
    $tagids = array();
    //debug($tagnames);
    foreach ($tagnames as $tagname){
      // get tag id numbers from names
      $t = $this->Tag->find('first',array('conditions'=>array('Tag.name LIKE "'.$tagname.'%"')));
      //debug($t);
      if ($t) {
	array_push($tagids,$t['Tag']['id']);
      }
      else {
	$this->Session->setFlash('Unknown subject tag: '.$tagname,'FlashBad');
      }    
    }
    return $tagids;
  }

  public function curator_cookie($key=null) {
    CakeLog::write('debug','curator_cookie page accessed');
    $this->set('readCookie', $this->Cookie->read('curator_cookie'));
    //debug($readCookie);
    if (!empty($this->data)) {
      CakeLog::write('debug','curator_cookie data submitted');
      if ($this->data['Admin']['admin_key'] == Configure::read('site.admin_key')) {
        CakeLog::write('debug','curator_cookie data matches!');
        //set cookie for curator usage
        //$this->Cookie->domain = 'mathmeetings.net';
        $this->Cookie->secure = true;  // i.e. only sent if using secure HTTPS
        $this->Cookie->httpOnly = true; // i.e. not accessible to javascript
        $this->Cookie->write('curator_cookie', Configure::read('site.curator_cookie'));
        $this->set('readCookie', $this->Cookie->read('curator_cookie'));
        
        $this->Session->setFlash('Curator cookie set!', 'FlashGood');
        return $this->redirect(array('action' => 'index'));
      }
    }
    
  }

  public function ical($id=null) {
    //not used?? (replaced by helper/view)
    return false;
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
    //not used?? (replaced by helper/view)
    return false;
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
    // Is this used for anything?
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


  public function view($id = null) {
    if (!$this->Conference->exists($id)) {
      throw new NotFoundException(__('Invalid conference'));
    }
    $this->Conference->id = $id;
    $this->set('conference', $this->Conference->read());
  }


  public function add($tagstring = null) {
    $this->set('countries',$this->loadCountries());
    $this->set('view_title', 'Add');
    $validCuratorcookie = $this->Cookie->read('curator_cookie') == Configure::read('site.curator_cookie'); // check for valid curator cookie
    $this->set('validCuratorcookie', $validCuratorcookie); 
    if (isset($tagstring)) {
      //debug($tagstring);
      $this->set('tagstring',$tagstring);
      $tagids=$this->tag_ids_from_names(explode('-', $tagstring));
      $this->set('tagids',$tagids);
    } 
    else {
      $this->set('tagstring','');
      $this->set('tagids',array());
    }

    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      $this->Conference->set($this->data);
      $this->Tag->set($this->data['Tag']);
	  
      //these don't really need separate variables but I did it anyway, feel free to include directly in IF statement
      $validconf=$this->Checker->conferenceValid($this->data['Conference']);
      $validtag=$this->Checker->tagValid($this->data['Tag']);


      // test whether conference and tag data validates

      // check for invalid conference data

      // if conference and tag data validates, check for 
      // valid captcha OR valid curatorcookie
      if ($validtag && $validconf &&
	  ($validCuratorcookie || $this->Recaptcha->verify())) {
	// all good !
	$this->save_and_send();
      }
      // else: something invalid
      else {
	$this->Conference->invalidate('recaptcha');
	//$this->Session->setFlash('Please complete captcha task.', 'FlashBad');
	//$this->Session->setFlash($this->Recaptcha->error);
	$this->Session->setFlash('Submission error.  Please check entries and verify captcha.', 'FlashBad');
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
      $tagnames = array();
      foreach($this->request->data['Tag'] as $tag) {
	$t = explode('.',$tag['name'])[0];
	array_push($tagnames,$t);
      }
      $tagstring = implode('-',$tagnames);
      //debug($tagstring);
      $Email = $this->prepEmail();
      $Email->send();
      $this->Session->setFlash('Your conference information has been saved.  An email with edit/delete links has been sent to the contact address.', 'FlashGood');
      return $this->redirect(array('action' => 'index',$tagstring));
    } 
    else {
      $this->Session->setFlash('There was an error saving the data','FlashBad');
    }
  }

  public function _getEmailer() {
    // function to return emailer, so we can replace it during automated tests
    return new CakeEmail();
  }

  public function prepEmail($id = null) {
    $Email = $this->_getEmailer();
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
    $admin_email = Configure::read('site.admin_email');
    $Email->bcc($admin_email['all']);
    $cc_array = [];
    foreach($this->data['Tag'] as $tag) {
      $t = explode('.',$tag['name'])[0];
      if (array_key_exists($t,$admin_email)) {
        $cc_array = array_merge($cc_array,$admin_email[$t]);
      }
    }
    //debug(array('cc'=>join($cc_array,',')));
    $Email->cc($cc_array);
    $Email->subject($this->data['Conference']['title']);
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
	return $this->redirect(array('action' => 'index'));
      }
    } 
    else {
      // check that given key matches key from database
      $prev = $this->Conference->find('first', array(
          'conditions' => array('Conference.id' => $id)
      ));
      if ($key != $prev['Conference']['edit_key']) {
        $this->Session->SetFlash('Invalid edit key. (1)','FlashBad');
        return $this->redirect(array('action' => 'index'));
      }

      $validconf=$this->Checker->conferenceValid($this->data['Conference']);
      $validtag=$this->Checker->tagValid($this->data['Tag']);
      // test whether conference and tag data validates
      // check for invalid conference data
      if ($validtag && $validconf) {
	$this->save_and_send();
      }
      else {
	$this->Session->setFlash('Please check for errors below.', 'FlashBad');
      }
    }
    //debug('rendering add');
    $this->render('add'); // always render the add view
  }
  

  public function delete($id = null, $key = null) {
    $this->Conference->id = $id;
    //debug($this->Conference->read('edit_key')['Conference']['edit_key']);
    if ($key != $this->Conference->read('edit_key')['Conference']['edit_key']) {
      $this->Session->SetFlash('Invalid edit key. (3)','FlashBad');
      return $this->redirect(array('action' => 'index'));
    }
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
  }


  public function loadCountries($file = "../webroot/files/countries/dist/countries.csv") {
    $tmpCountries = array();
    $tmpCountries['country'] =  "Country...";
    if (($handle = fopen($file, "r")) !== FALSE) {
      //setlocale(LC_CTYPE, "en.UTF16"); // for unicode; seems to be unnecessary
      $data0 = fgetcsv($handle, 1000, ";");
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
	$name = preg_split('/,/',$data[0])[0];
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


}
