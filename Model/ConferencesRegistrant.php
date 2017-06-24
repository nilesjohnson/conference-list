<?php
App::uses('AppModel', 'Model');

class ConferencesRegistrant extends AppModel {

	public $belongsTo = array(
		'Conference' => array(
			'className' => 'Conference',
			'foreignKey' => 'conference_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Registrant' => array(
			'className' => 'Registrant',
			'foreignKey' => 'registrant_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
