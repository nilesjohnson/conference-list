<?php
App::uses('AppController', 'Controller');
/**
 * Registrants Controller
 *
 * @property Registrant $Registrant
 * @property PaginatorComponent $Paginator
 */

class RegistrantsController extends AppController {


  var $name = 'Registrants';
  //var $hasOne = 'CcData';  // model for cc data

  var $months = array("none", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");


  public $helpers = array('Js', 'Html', 'Gcal', 'Text');

  public $components = array('Email', 'RequestHandler', 'Session', 'MathCaptcha', 'Security', 'Paginator');

  public $paginate = array(
			   'limit' => 100,
			   'order' => array(
					    'Registrant.last_name' => 'asc',
					    'Registrant.first_name' => 'asc'
					    ),
			   'conditions' => array('Registrant.request_pub' => '1')
			   );


  public function beforeFilter() {
    $this->Security->blackHoleCallback = 'blackhole';
  }

  public function blackhole($type) {
    CakeLog::write('debug','Blackholed request.  Session data follow.');
    CakeLog::write('debug','Blackhole type: '.$type);
    CakeLog::write('debug','User Agent: '.print_r($this->Session->userAgent(),$return=true));

    if (!(empty($this->data))) {
      if (array_key_exists('Registrant',$this->data)) {
	CakeLog::write('debug',"name: ".$this->data['Registrant']['name']);
	CakeLog::write('debug',"email: ".$this->data['Registrant']['email']);
	CakeLog::write('debug',"captcha: ".$this->data['Registrant']['captcha']);
      }
      else {
	CakeLog::write('debug','No other data.');
      }
    }
    if ($type == 'csrf') {
      throw new BadRequestException('CSRF token is either expired or corrupted.');
    }
    else {
      throw new BadRequestException('Unknown security error: request has been black-holed');
    }
  }

  public function index($s=Null) {
    $this->set('view_title','index');
  }

  public function abstracts($s=Null) {
    $this->set('view_title','abstracts');
  }

  public function local($s=Null) {
    $this->set('view_title','local');
  }

  public function organizers($s=Null) {
    $this->set('view_title','organizers');
  }

  public function all($sort_condition=Null) {
    // show all registrants
    $this->set('view_title','current registrants');
    $this->Paginator->settings = $this->paginate;

    // find database entries
    //$find_array = array('conditions' => $conditions, 'order' => $order_array);    
    $this->set('regCount', count($this->Registrant->find('all')));
    $this->set('registrants', $this->Paginator->paginate('Registrant'));

    // process RSS feed      
    if( $this->RequestHandler->isRss() ){
      $this->set(compact('registrants'));
    }
  }

  public function adminall($key = Null) {
    // show all registrants
    if ($key != Configure::read('site.admin_key')) {
      $this->Session->SetFlash('Invalid admin key.','FlashBad');
      $this->redirect(array('action' => 'index'));
    }
    $this->set('view_title','administrator\'s list');
    $this->Paginator->settings = $this->paginate;
    $this->Paginator->settings['conditions'] = array();

    // find database entries
    //$find_array = array('conditions' => $conditions, 'order' => $order_array);    
    $this->set('regCount', count($this->Registrant->find('all')));
    $this->set('registrants', $this->Paginator->paginate('Registrant'));

    // process RSS feed      
    if( $this->RequestHandler->isRss() ){
      $this->set(compact('registrants'));
    }
  }


  

  public function view($id = null) {
    if (!$this->Registrant->exists($id)) {
      throw new NotFoundException(__('Invalid registrant'));
    }
    $this->Registrant->id = $id;
    $this->set('registrant', $this->Registrant->read());
  }


  public function add() {
    $this->set('noRegButton',1);
    $this->set('view_title', 'Add');
    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      $this->Registrant->set($this->data);
      // continue on with validation
      if ($this->doValidation()) {
	$this->saveAndSend();
      }
      else {
	$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	$this->render('addedit');
      }
    }
    // if there is no data: generate a fresh form
    $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
    $this->render('addedit');
  }

  public function edit($id = null, $key = null) {
    $this->set('noRegButton',1);
    if (!$this->Registrant->exists($id)) {
      throw new NotFoundException(__('Invalid registrant'));
    }
    $this->Registrant->id = $id;
    $this->set('edit',1);
    if (empty($this->data)) {
      $this->data = $this->Registrant->read();
      // allow admin key: if given, set $key to correct edit key
      if ($key == Configure::read('site.admin_key')) {
	$key = $this->data['Registrant']['edit_key'];
      }
      $this->request->data['Registrant']['passed_key'] = $key;
      //debug($this->data);

      if ($key != $this->data['Registrant']['edit_key']) {
	$this->Session->SetFlash('Invalid edit key. (2)','FlashBad');
	$this->redirect(array('action' => 'index'));
      }
      $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
      $this->render('addedit');
    } 
    else {
      // check that given key matches key from database
      $this->Registrant->set($this->data);
      $prev = $this->Registrant->find('first', array(
          'conditions' => array('Registrant.id' => $id)
      ));
      if ($key != $prev['Registrant']['edit_key'] && $key != Configure::read('site.admin_key')) {
        $this->Session->SetFlash('Invalid edit key. (1)','FlashBad');
        $this->redirect(array('action' => 'index'));
      }
      // continue on with validation
      if ($this->doValidation()) {
	$this->saveAndSend();
      }
      else {
	$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	$this->render('addedit');
      }
    }
  }
  
  public function doValidation() {
    // test whether registrant data validates
    $valid_data = true;
    // check for invalid registrant data
    if (!($this->Registrant->validates($this->data['Registrant']))) {
      //debug($this->Registrant->validationErrors); //displays array info
      $valid_data = false;
    }      

    // also check for valid captcha
    if ($valid_data && $this->MathCaptcha->validates($this->data['Registrant']['captcha'])) {
      return true;
    }

    foreach (Set::flatten($this->Registrant->validationErrors) as $field => $message) {
      $this->Registrant->invalidate($field,$message);
    }
    $this->Session->setFlash('Please check for errors below.', 'FlashBad');
    $this->Registrant->invalidate('captcha','Please perform the indicated arithmetic.');
    return false;
  }

  public function saveAndSend() {
    /*
     * helper function to validate, save data and send email
     * ends with redirect
     */
    
    // verify that all data saves, and send email(s)
    if ($this->Registrant->save($this->data)) {
      $this->request->data = $this->Registrant->read();
      $Email = $this->prepEmail();
      $Email->send();
      $this->Session->setFlash('Your registration information has been saved.  An email with edit/delete links has been sent to the contact address.', 'FlashGood');
      $this->redirect(array('action' => 'index'));
    } 
    // else: don't know
    else {
      $this->Session->setFlash('There was an error saving your data.  Please retry or contact the organizers.', 'FlashBad');
      $this->redirect(array('action' => 'index'));  
    }
  }

  public function prepEmail($id = null) {
    $Email = new CakeEmail();
    if (!is_null($id)) {
      $this->Registrant->id = $id;
      if (!$this->Registrant->exists($id)) {
	throw new NotFoundException(__('Invalid registrant (3)'));
      }
      $this->data = $this->Registrant->read();
    }
    $Email->viewVars(array('registrant' => $this->data));
    $Email->template('default','default')
      ->emailFormat('text');
    $Email->from(array(Configure::read('site.host_email') => Configure::read('site.name')));
    $Email->to($this->data['Registrant']['email']);
    $Email->bcc(Configure::read('site.admin_email'));
    $Email->subject("Registration for " . $this->data['Registrant']['name']);
    if (!is_null($id)) {
      $this->set('registrant',$this->data);
      $this->render('../Emails/text/default','Emails/text/default');
      return null;
    }
    return $Email;
  }


  public function delete($id = null) {
    $this->Registrant->id = $id;
    if (!$this->Registrant->exists()) {
      throw new NotFoundException(__('Invalid registrant'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Registrant->delete()) {
      $this->Session->setFlash('The registrant announcement has been deleted.', 'FlashGood');
    }
    else {
      $this->Session->setFlash(__('The registrant could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
  }


  public function about() {
    $this->set('view_title','About');
  }


  public function admin($id) {
    $this->set('valid_admin',false);
    if (!$this->Registrant->exists($id)) {
      throw new NotFoundException(__('Invalid registrant'));
    }
    $this->Registrant->id = $id;
    $this->set('registrant', $this->Registrant->read());
    if (!empty($this->data)) {
      // set model data
      //debug($this->data);  //displays array info
      if ($this->data['Admin']['admin_key'] == Configure::read('site.admin_key') || $this->data['Admin']['admin_key'] == $this->Registrant->field('edit_key')) {
	  $this->set('valid_admin',true);
	}
    }
    /*
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.";
    $key_array = str_split($this->Registrant->field('edit_key'));
    $shift_array = array(18,3,-12,24,-5,-7,2,21);
    $i = 0;
    foreach ($key_array as $l) {
      $key_code_array[] = (strpos($chars,$l) + $shift_array[$i]) % 62;
      $i = $i+1;
    }
    $this->set('key_code','['.implode(',',$key_code_array).']');
    //$this->set('key_code', $this->Registrant->field('edit_key'));
    */
  }




}
