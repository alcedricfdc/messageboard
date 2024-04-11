<?php
App::uses('AppModel', 'Model');
/**
 * Conversation Model
 *
 * @property Participant $Participant
 */
class Conversation extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'created_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function getConversationsForUser($userId, $count)
	{
		return $this->find('all', array(
			'joins' => array(
				array(
					'table' => 'participants',
					'alias' => 'Participant',
					'type' => 'INNER',
					'conditions' => array(
						'Participant.conversation_id = Conversation.id',
						'Participant.user_id' => $userId
					)
				)
			),
			'limit' => $count
		));
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Participant' => array(
			'className' => 'Participant',
			'foreignKey' => 'conversation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'conversation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
