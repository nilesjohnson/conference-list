<?php
App::uses('AppModel', 'Model');

class Tag extends AppModel {

	public $hasAndBelongsToMany = array(
		'Conference' => array(
			'className' => 'Conference',
			'joinTable' => 'conferences_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'conference_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with'=>'ConferencesTag'
		)
	);

}
