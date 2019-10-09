<?php

namespace App\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

use Cake\ORM\TableRegistry;

class CategoriesController extends AppController
{

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');                   
    }

    public function beforeFilter(Event $event){
	    $this->viewBuilder()->layout('backend');
	}

	public function index()
    {       
        $categories = $this->Paginator->paginate($this->Categories->find()->order(['Categories.created' => 'DESC']), ['maxLimit' => 10]);
        $this->set(compact('categories'));
    }

	public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Your category has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your category.'));
        }

        $categories = $this->Categories->find('list'); 
        	    
	    $this->set('categories', $categories);

        $this->set('category', $category);
    }

    public function edit($id)
	{
	    $category = $this->Categories->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	        $this->Categories->patchEntity($category, $this->request->getData());
	        if ($this->Categories->save($category)) {
	            $this->Flash->success(__('Your category has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update your category.'));
	    }

	    $categories = $this->Categories->find('relations', [
	        'this_id' => $id
	    ]); // to not include self and child categoriesea
	    
	    $this->set('categories', $categories);

	    $this->set('category', $category);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $category = $this->Categories->findById($id)->firstOrFail();

	    $this->Categories->updateAll(array("parent_id"=>null),array("parent_id"=>$id));
	    $articles = TableRegistry::get('Articles');
	    $articles->updateAll(array("category_id"=>null),array("category_id"=>$id));

	    if ($this->Categories->delete($category)) {
	        $this->Flash->success(__('The {0} category has been deleted.', $category->title));
	        return $this->redirect(['action' => 'index']);
	    }
	}

	public function isAuthorized($user)
	{
	    
		$action = $this->request->getParam('action');

	    if ($this->Auth->user('role_id') < 3 && in_array($action, array('add', 'edit', 'delete', 'index'))) {				
			return true;
		} 

		if($this->Auth->user('role_id') == 3 && in_array($action, array('index'))) {
			return true;
		}
	    
	}

}