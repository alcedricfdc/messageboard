<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 */
class MessagesController extends AppController
{

	public $components = array('Paginator');

	public function beforeFilter()
	{
		$this->RequestHandler = $this->Components->load('RequestHandler');
	}

	public function index()
	{
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		$this->Message->recursive = 0;
		$this->set('messages', $this->Paginator->paginate());
	}


	public function view($id = null)
	{
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));
	}






	public function getMessages()
	{
		if ($this->RequestHandler->isAjax()) {
			$conversation_id = $this->params['data']['conversation_id'];
			$page_count = $this->params['data']['page_count'];

			$items_count = $page_count * 5;

			$userId = $this->Auth->user('id');

			$messages = $this->Message->find('all', array(
				'conditions' => array(
					'Message.conversation_id' => $conversation_id,
				),
				'order' => array(
					'Message.created DESC'
				),
				'limit' => $items_count
			));

			foreach ($messages as &$message) {
				$message_user_id = $message['Participant']['user_id'];

				if ($message_user_id == $userId) {
					$message['Participant']['isSelf'] = true;
				} else {
					$message['Participant']['isSelf'] = false;
				}


				$user = $this->Message->Participant->User->findById($message_user_id);

				if ($user) {
					$message['Participant']['name'] = $user['User']['name'];
					$message['Participant']['profile_picture'] = $user['User']['profile_picture'];
					$message['Participant']['email'] = $user['User']['email'];
				} else {
					$message['Participant']['name'] = 'Unknown';
					$message['Participant']['profile_picture'] = null;
					$message['Participant']['email'] = null;
				}
			}


			$response = [
				'messages' => $messages
			];

			$this->set('response', $messages);
		}
	}


	public function add()
	{

		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));
	}

	public function edit($id = null)
	{
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Flash->success(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
		$participants = $this->Message->Participant->find('list');
		$this->set(compact('participants'));
	}


	public function searchMessage()
	{
		if ($this->RequestHandler->isAjax()) {
			$conversation_id = $this->params['data']['conversation_id'];
			$searchInput = $this->params['data']['searchInput'];

			$userId = $this->Auth->user('id');

			$messages = $this->Message->find('all', array(
				'conditions' => array(
					'Message.message LIKE' => '%' . $searchInput . '%',
					'Message.conversation_id' => $conversation_id,
				)
			));

			foreach ($messages as &$message) {
				$sender_user_id = $message['Participant']['user_id'];

				$user = $this->Message->Participant->User->findById($sender_user_id);

				if ($user) {
					if($user['User']['id'] == $userId) {
						$message['Message']['sender'] = 'You';
					} else {
						$message['Message']['sender'] = $user['User']['name'];
					}
				} else {
					$message['Message']['sender'] = 'Unknown';
				}
			}

			$this->autoRender = false;
			$this->response->type('json');
			echo json_encode($messages);
		}
	}


	public function delete($id = null)
	{
		$response = array();

		if (!$this->Message->exists($id)) {
			$response['success'] = false;
			$response['message'] = 'Invalid message';
		} else {
			$this->request->allowMethod('post', 'delete');

			if ($this->Message->delete($id)) {
				$response['success'] = true;
				$response['message'] = 'The message has been deleted.';
			} else {
				$response['success'] = false;
				$response['message'] = 'The message could not be deleted. Please, try again.';
			}
		}

		$this->autoRender = false;
		$this->response->type('json');
		echo json_encode($response);
	}
}
