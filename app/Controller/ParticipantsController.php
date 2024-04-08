<?php
App::uses('AppController', 'Controller');
/**
 * Participants Controller
 *
 * @property Participant $Participant
 * @property PaginatorComponent $Paginator
 */
class ParticipantsController extends AppController {

	public $components = array('Paginator');

	public function index() {
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		$this->Participant->recursive = 0;
		$this->set('participants', $this->Paginator->paginate());
	}

	public function view($id = null) {
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		
		if (!$this->Participant->exists($id)) {
			throw new NotFoundException(__('Invalid participant'));
		}
		$options = array('conditions' => array('Participant.' . $this->Participant->primaryKey => $id));
		$this->set('participant', $this->Participant->find('first', $options));
	}

	public function add() {
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		if ($this->request->is('post')) {
			$this->Participant->create();
			if ($this->Participant->save($this->request->data)) {
				$this->Flash->success(__('The participant has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The participant could not be saved. Please, try again.'));
			}
		}
		$users = $this->Participant->User->find('list');
		$conversations = $this->Participant->Conversation->find('list');
		$this->set(compact('users', 'conversations'));
	}

	public function edit($id = null) {
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		if (!$this->Participant->exists($id)) {
			throw new NotFoundException(__('Invalid participant'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Participant->save($this->request->data)) {
				$this->Flash->success(__('The participant has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The participant could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Participant.' . $this->Participant->primaryKey => $id));
			$this->request->data = $this->Participant->find('first', $options);
		}
		$users = $this->Participant->User->find('list');
		$conversations = $this->Participant->Conversation->find('list');
		$this->set(compact('users', 'conversations'));
	}


	public function delete($id = null) {
		return $this->redirect(array('controller' => 'conversations', 'action' => 'index'));

		if (!$this->Participant->exists($id)) {
			throw new NotFoundException(__('Invalid participant'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Participant->delete($id)) {
			$this->Flash->success(__('The participant has been deleted.'));
		} else {
			$this->Flash->error(__('The participant could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
