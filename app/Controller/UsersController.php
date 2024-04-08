<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController
{

	public $components = array('Paginator', 'Flash');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add', 'validateForm');
		$this->RequestHandler = $this->Components->load('RequestHandler');
	}


	public function login()
	{
		if (AuthComponent::user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');

				$this->User->save(array('last_login' => date('Y-m-d H:i:s'), 'modified' => false));

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('Invalid Username or Password');
			}
		}
	}

	public function logout()
	{
		$this->Auth->logout();
		$this->redirect('/users/login');
	}

	public function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}


	public function view($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	public function validateForm()
	{
		if ($this->RequestHandler->isAjax()) {
			$this->request->data['User'][$this->params['data']['field']] = $this->params['data']['value'];
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$this->autoRender = FALSE;
			} else {
				$error = $this->validateErrors($this->User);
				$errorMessage = is_array($error[$this->params['data']['field']]) ? implode(', ', $error[$this->params['data']['field']]) : $error[$this->params['data']['field']];
				$this->set('error', $errorMessage);
			}
		}
	}

	public function searchRecipient()
	{

		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->autoRender = false;

			$searchQuery = $this->request->query['q'];
			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.name LIKE' => '%' . $searchQuery . '%'
				)
			));

			$results = array();
			foreach ($users as $user) {
				$results[] = array(
					'id' => $user['User']['id'],
					'text' => $user['User']['name']
				);
			}

			$this->response->type('json');
			echo json_encode($results);
		}
	}

	

	public function thankYou()
	{
	}

	public function uploadProfileImage()
	{
		if ($this->request->is('post') && !empty($this->data['User']['image']['tmp_name'])) {
			$uploadDir = WWW_ROOT . 'img' . DS . 'user_profile_uploads' . DS;

			$file = $this->data['User']['image'];

			$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

			$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
			if (!in_array($extension, $allowedExtensions)) {
				$this->Flash->error(__('Invalid file extension. Please upload a valid image file (JPEG, JPG, PNG, GIF).'), 'flash_error');
				$this->redirect($this->referer());
				return;
			}

			$randomString = bin2hex(random_bytes(10));

			$extension = pathinfo($file['name'], PATHINFO_EXTENSION);

			$filename = $randomString . '.' . $extension;

			if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
				$this->User->id = $this->Auth->user('id'); 
				$this->User->save(array('profile_picture' => $filename));

				$this->Flash->success(__('Profile image uploaded successfully.'), 'flash_success');
			} else {
				$this->Flash->error(__('Failed to upload profile image. Please try again.'), 'flash_error');
			}
		} else {
			$this->Flash->error(__('Please select an image file to upload.'), 'flash_error');
		}

		$this->redirect($this->referer());
	}

	public function add()
	{
		if (AuthComponent::user()) {
			$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		} 

		if ($this->request->is('post')) {
			$this->User->create();

			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
			$this->request->data['User']['profile_picture'] = '';

			$ipAddress = $this->RequestHandler->getClientIp();

			$this->request->data['User']['created_ip'] = $ipAddress;
			$this->request->data['User']['modified_ip'] = $ipAddress;
			$this->request->data['User']['last_login'] = date('Y-m-d H:i:s');

			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'thankYou'));
			} else {

				$errors = $this->validateErrors($this->User);
				$flattenedErrors = Hash::flatten($errors);

				$errorMessages = implode(' | ', $flattenedErrors);
				$this->Flash->error(__($errorMessages));
			}
		}
	}

	public function edit($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if (AuthComponent::user('id') != $id) {
			$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		} 

		if ($this->request->is(array('post', 'put'))) {
			unset($this->request->data['User']['profile_picture']);

			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

	public function changePassword($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if (AuthComponent::user('id') != $id) {
			$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		} 

		if ($this->request->is(array('post', 'put'))) {

			$this->request->data['User']['id'] = $id;

			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);

			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user password has been updated.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->error(__('The user password could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

	public function delete($id = null)
	{
		$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if (AuthComponent::user('id') != $id) {
			$this->redirect(array('controller' => 'conversations', 'action' => 'index'));
		} 
		
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete($id)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
