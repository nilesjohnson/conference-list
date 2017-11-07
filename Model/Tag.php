<?php
App::uses('AppModel', 'Model');

class Tag extends AppModel {
  public $validate = array(
			   'Tag' => array(
					  // something has to be here
					  // so that field is flagged as
					  // required on the add form
					  // but the rule is not used.
					  //
					  //'rule' => 'notBlank',
					  'message' => 'Please supply at least one subject tag.'
					  ),
			   );

  public $hasAndBelongsToMany = array(
	     'Conference' => array(
		        'className' => 'Conference',
			'joinTable' => 'conferences_tags',
			'foreignKey' => 'tag_id',
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
			'with'=>'ConferencesTag'
				   )
				      );


  public function tagsValidator($check) {
    // this is called in the controller
    //debug($check);
    return ($check['Tag']!=false);
  }

}
