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

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Flash');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow();
		$this->RequestHandler = $this->Components->load('RequestHandler');
	}

	/**
	 * index method
	 *
	 * @return void
	 */

	public function login()
	{
		if (AuthComponent::user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) { // login the user using the login method provided by the Auth component
				$this->User->id = $this->Auth->user('id'); // Assuming the id field is 'id', adjust as needed

				$this->User->save(array('last_login' => date('Y-m-d H:i:s'), 'modified' => false));

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('Invalid Username or Password');
			}
		}
	}

	public function logout() {
		$this->Auth->logout();
		$this->redirect('/users/login');
	}

	public function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */

	// we can access the values from the ajax in the $this->params['form']
	public function validateForm()
	{
		if ($this->RequestHandler->isAjax()) {
			$this->request->data['User'][$this->params['data']['field']] = $this->params['data']['value'];
			$this->User->set($this->request->data);
			if ($this->User->validates()) { // check if it is valid
				$this->autoRender = FALSE; // set the autorender to false so that cakephp wont render the validate_form view by default
			} else {
				$error = $this->validateErrors($this->User); // this is going to pull all of the validation errors for the model
				$errorMessage = is_array($error[$this->params['data']['field']]) ? implode(', ', $error[$this->params['data']['field']]) : $error[$this->params['data']['field']];
				$this->set('error', $errorMessage);
			}
		}
	}

	public function thankYou() {

	}

	public function uploadProfileImage() {
        // Check if the form is submitted and file is uploaded
        if ($this->request->is('post') && !empty($this->data['User']['image']['tmp_name'])) {
            // Define upload directory
            $uploadDir = WWW_ROOT . 'img' . DS . 'user_profile_uploads' . DS;

            // Get the uploaded file
            $file = $this->data['User']['image'];

			// Extract original file extension
			$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

			// Check if the file extension is allowed
			$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
			if (!in_array($extension, $allowedExtensions)) {
				$this->Flash->error(__('Invalid file extension. Please upload a valid image file (JPEG, JPG, PNG, GIF).'), 'flash_error');
				$this->redirect($this->referer());
				return; // Stop further execution
			}

			$randomString = bin2hex(random_bytes(10)); 

			// Extract original file extension
			$extension = pathinfo($file['name'], PATHINFO_EXTENSION);

			$filename = $randomString .'.'.$extension;

            // Move the file to the upload directory
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                // File uploaded successfully
                // You may want to update the user's profile image path in the database
				$this->User->id = $this->Auth->user('id'); // Assuming the id field is 'id', adjust as needed
				$this->User->save(array('profile_picture' => $filename));

                $this->Flash->success(__('Profile image uploaded successfully.'), 'flash_success');
            } else {
                // Failed to upload the file
                $this->Flash->error(__('Failed to upload profile image. Please try again.'), 'flash_error');
            }
        } else {
            // No file uploaded
            $this->Flash->error(__('Please select an image file to upload.'), 'flash_error');
        }

        // Redirect back to the page
        $this->redirect($this->referer());
    }

	public function add()
	{

		if ($this->request->is('post')) {
			$this->User->create();

			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
			$this->request->data['User']['profile_picture'] = '';

			// Get the user's IP address
			$ipAddress = $this->RequestHandler->getClientIp();

			// Set the user's IP address to the created_ip field
			$this->request->data['User']['created_ip'] = $ipAddress;
			$this->request->data['User']['modified_ip'] = $ipAddress;
			$this->request->data['User']['last_login'] = date('Y-m-d H:i:s');

			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'thankYou'));
			} else {
				// $this->Flash->error(__('The user could not be saved. Please, try again.'));

				$errors = $this->validateErrors($this->User); // this is going to pull all of the validation errors for the model
				// Flatten errors array for better readability
				$flattenedErrors = Hash::flatten($errors);

				// Format the error messages
				$errorMessages = implode(' | ', $flattenedErrors);
				$this->Flash->error(__($errorMessages));
			}
		}
	}


	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
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

	public function changePassword($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
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

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
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
