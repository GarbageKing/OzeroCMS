<?php

namespace App\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

class TagsController extends AppController
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
        $tags = $this->Paginator->paginate($this->Tags->find()->order(['Tags.created' => 'DESC']), ['maxLimit' => 10]);
        $this->set(compact('tags'));
    }

	public function add()
    {
        $tag = $this->Tags->newEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());

            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('Your tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your tag.'));
        }
        $this->set('tag', $tag);
    }

    public function edit($id)
	{
	    $tag = $this->Tags->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	        $this->Tags->patchEntity($tag, $this->request->getData());
	        if ($this->Tags->save($tag)) {
	            $this->Flash->success(__('Your tag has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update your tag.'));
	    }

	    $this->set('tag', $tag);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $tag = $this->Tags->findById($id)->firstOrFail();
	    if ($this->Tags->delete($tag)) {
	        $this->Flash->success(__('The {0} tag has been deleted.', $tag->title));
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