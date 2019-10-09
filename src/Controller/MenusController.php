<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class MenusController extends AppController
{

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); 
        $this->loadComponent('Global'); 
        $this->Auth->allow([]);
    }

    public function beforeFilter(Event $event){
	    $this->viewBuilder()->layout('backend');
	}

	public function index()
    {       
        $items = $this->Menus->find()->order(['Menus.placement']); 
        $item_new = $this->Menus->newEntity();

        $this->set(compact('items'));  
        $this->set(compact('item_new'));      
    }

    public function add()
    {
        $item = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Menus->patchEntity($item, $this->request->getData());

            if ($this->Menus->save($item)) {
                $this->Flash->success(__('Your menu item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your menu item.'));
        }
		$this->autoRender = false;
    }
   
    public function edit($id)
	{
	    $item = $this->Menus->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	    	$values = $this->request->getData();	    	
	        $this->Menus->patchEntity($item, $values);
        	
	        if ($this->Menus->save($item)) {
	            $this->Flash->success(__('Your menu item has been updated.'));
	            return $this->redirect(['action' => 'index']);
	        }
	        $this->Flash->error(__('Unable to update your menu item.'));
	    }
	    $this->autoRender = false;
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $item = $this->Menus->findById($id)->firstOrFail();

	    if ($this->Menus->delete($item)) {
	        $this->Flash->success(__('The {0} item has been deleted.', $item->name));
	        return $this->redirect(['action' => 'index']);
	    }
	}

	public function isAuthorized($user)
	{
	    $action = $this->request->getParam('action');
	    
	    if (in_array($action, array('add', 'edit', 'delete', 'index')) && $this->Auth->user('role_id') < 3) {
	        return true;
	    }

	    $id = $this->request->getParam('pass.0');
	    if (!$id || $this->Auth->user('role_id') > 2) {
	        return false;
	    }

	    
	}
}