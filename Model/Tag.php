<?php
App::uses('AppModel', 'Model');

class Tag extends AppModel {
  public $validate = array(
			   'Tag' => array(
					  'rule' => 'notEmpty',
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
    // not used
    debug($check);
    return false;
    //return ($check['Tag']!=false);
  }

}
