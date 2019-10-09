<?php

namespace App\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

class UsersController extends AppController
{

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); 
        $this->loadComponent('Global'); 
        $this->Auth->allow(['logout', 'register']);
    }

	public function index()
    {       
    	$this->viewBuilder()->layout('backend');
        $users = $this->Paginator->paginate($this->Users->find()->order(['Users.created' => 'DESC']), ['maxLimit' => 10]);
        $this->set(compact('users'));
    }

	public function add()
    {
    	$this->viewBuilder()->layout('backend');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add user.'));
        }
        $roles = $this->Users->Roles->find('list');
        $this->set(['user'=> $user, 'roles'=>$roles]);
    }

    public function register()
    {
    	$this->viewBuilder()->layout('auth');
    	if($this->Global->canRegister()){
	        $user = $this->Users->newEntity();
	        if ($this->request->is('post')) {
	            $user = $this->Users->patchEntity($user, $this->request->getData());
	            $user->role_id = 4; //default lowest

	            if ($this->Users->save($user)) {
	                $this->Flash->success(__('Registered successfully.'));
	                return $this->redirect(['action' => 'login']);
	            }
	            $this->Flash->error(__('Unable to register user.'));
	        }
	        $this->set('user', $user);
    	} else {
    		$this->Flash->error(__('Registration disabled'));
    		return $this->redirect($this->request->referer());
    	}
    }

    public function edit($id)
	{
		$this->viewBuilder()->layout('backend');
	    $user = $this->Users->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	        $this->Users->patchEntity($user, $this->request->getData());
	        if ($this->Users->save($user)) {
	            $this->Flash->success(__('User has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update user.'));
	    }

	    $roles = $this->Users->Roles->find('list');
        $this->set(['user'=> $user, 'roles'=>$roles]);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);
	    
	    $user = $this->Users->findById($id)->firstOrFail();

	    if($this->Users->find()->count() != 1){
	    	if ($this->Users->delete($user)) {
		        $this->Flash->success(__('The {0} user has been deleted.', $user->email));
		        if($this->Auth->user('id') == $id){
		        	return $this->redirect($this->Auth->logout());
		        } else {
		        	return $this->redirect(['action' => 'index']);
		        }		        
		    }
	    } else {
	    	$this->Flash->error(__('Unable to delete the last user'));
	    	return $this->redirect(['action' => 'index']);
	    }
	    
	}

	public function login()
	{
		$this->viewBuilder()->layout('auth');
	    if ($this->request->is('post')) {
	        $user = $this->Auth->identify();
	        if ($user) {
	            $this->Auth->setUser($user);
	            if($this->Auth->user('role_id') != 4){
	            	return $this->redirect($this->Auth->redirectUrl());
	            } else {
	            	return $this->redirect($this->Global->startingPage());
	            }	            
	        }
	        $this->Flash->error('Your username or password is incorrect.');
	    }
	}

	public function logout()
	{
	    $this->Flash->success('You are now logged out.');
	    return $this->redirect($this->Auth->logout());
	}

	public function isAuthorized($user)
	{	    
	    $action = $this->request->getParam('action');

	    if ($this->Auth->user('role_id') < 4 && in_array($action, array('index'))) {
			return true;
		} 

		if($this->Auth->user('role_id') == 1 && in_array($action, array('add', 'edit', 'delete'))) {
			return true;
		}	    
	    
	}
}