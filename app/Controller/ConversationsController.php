<?php
App::uses('AppController', 'Controller');
/**
 * Conversations Controller
 *
 * @property Conversation $Conversation
 * @property PaginatorComponent $Paginator
 */
class ConversationsController extends AppController
{

	public $components = array('Paginator', 'Flash');

	public function beforeFilter()
	{
		$this->RequestHandler = $this->Components->load('RequestHandler');
	}

	public function index()
	{
		// $this->Conversation->recursive = 0;
		// $this->set('conversations', $this->Paginator->paginate());

		$userId = $this->Auth->user('id');
		$conversations = $this->Conversation->getConversationsForUser($userId);

		// Fetch user data for each participant
		foreach ($conversations as &$conversation) {
			foreach ($conversation['Participant'] as &$participant) {
				if ($participant['user_id'] !== $userId) {
					$user = $this->Conversation->Participant->User->findById($participant['user_id']);
					$participant['name'] = $user['User']['name'];
					$participant['profile_picture'] = $user['User']['profile_picture'];
					$participant['email'] = $user['User']['email'];
				}
			}
		}
		$this->set('conversations', $conversations);
	}

	public function view($id = null)
	{
		if (!$this->Conversation->exists($id)) {
			throw new NotFoundException(__('Invalid conversation'));
		}


		$options = array('conditions' => array('Conversation.' . $this->Conversation->primaryKey => $id));
		$conversation = $this->Conversation->find('first', $options);

		$userId = $this->Auth->user('id');

		$participantsIds = [];

		foreach ($conversation['Participant'] as &$participant) {
			$participantsIds[] = $participant['user_id'];

			$user = $this->Conversation->Participant->User->findById($participant['user_id']);
			$participant['name'] = $user['User']['name'];
			$participant['profile_picture'] = $user['User']['profile_picture'];
			$participant['email'] = $user['User']['email'];

			if ($participant['user_id'] == $userId) {
				$user_participant_id = $participant['id'];
			}
		}

		if(!in_array(AuthComponent::user('id'), $participantsIds)) {
			$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		}

		$this->set('conversation', $conversation);
		$this->set('user_participant_id', $user_participant_id);
	}

	

	public function replyMessage()
	{
		if ($this->RequestHandler->isAjax()) {
			$conversation_id = $this->params['data']['conversation_id'];
			$message = $this->params['data']['message'];

			$userId = $this->Auth->user('id');

			$participant = $this->Conversation->Participant->find('first', array(
				'conditions' => array(
					'Participant.user_id' => $userId,
					'Participant.conversation_id' => $conversation_id
				),
				'fields' => array('Participant.id')
			));

			if ($participant) {
				$participant_id = $participant['Participant']['id'];

				$this->Conversation->Participant->Message->create();
				$this->request->data['Message']['participant_id'] = $participant_id;
				$this->request->data['Message']['conversation_id'] = $conversation_id;
				$this->request->data['Message']['message'] = $message;

				if ($this->Conversation->Participant->Message->save($this->request->data)) {
					$response = 'Message have been saved';
				} else {
					$this->Flash->error(__('Message could not be saved.'));
				}
			} else {
				$response = 'Participant not found';
			}

			$this->set('response', $response);
		}
	}
	public function add()
	{
		if ($this->request->is('post')) {
			$recipient_id = $this->request->data['Conversation']['recipient_id'];
			$message = $this->request->data['Conversation']['message'];

			$users_id = array(AuthComponent::user('id'), $recipient_id);

			$this->Conversation->create();
			$this->request->data['Conversation']['created_by'] = AuthComponent::user('id');

			if ($this->Conversation->save($this->request->data)) {
				$conversation_id = $this->Conversation->getLastInsertId();

				$participantsData = array();

				foreach ($users_id as $user_id) {
					$participantsData[] = array(
						'user_id' => $user_id,
						'conversation_id' => $conversation_id
					);
				}

				if ($this->Conversation->Participant->saveMany($participantsData)) {

					$participant_id = $this->Conversation->Participant->field('id', array(
						'user_id' => AuthComponent::user('id'),
						'conversation_id' => $conversation_id
					));

					$this->Conversation->Participant->Message->create();
					$this->request->data['Message']['participant_id'] = $participant_id;
					$this->request->data['Message']['conversation_id'] = $conversation_id;
					$this->request->data['Message']['message'] = $message;

					if ($this->Conversation->Participant->Message->save($this->request->data)) {
						$this->Flash->success(__('Message have been saved.'));
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Flash->error(__('Message could not be saved.'));
					}
				} else {
					$this->Flash->error(__('Participants could not be saved.'));
				}
			} else {
				$this->Flash->error(__('The conversation could not be saved. Please, try again.'));
			}
		}
	}


	public function edit($id = null)
	{
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		if (!$this->Conversation->exists($id)) {
			throw new NotFoundException(__('Invalid conversation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Conversation->save($this->request->data)) {
				$this->Flash->success(__('The conversation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The conversation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Conversation.' . $this->Conversation->primaryKey => $id));
			$this->request->data = $this->Conversation->find('first', $options);
		}
	}

	public function delete($id = null)
	{
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		
		if (!$this->Conversation->exists($id)) {
			throw new NotFoundException(__('Invalid conversation'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Conversation->delete($id)) {
			$this->Flash->success(__('The conversation has been deleted.'));
		} else {
			$this->Flash->error(__('The conversation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
