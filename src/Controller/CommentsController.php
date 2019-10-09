<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class CommentsController extends AppController
{

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); 
        $this->loadComponent('Global');         
    }

    public function beforeFilter(Event $event){
	    $this->viewBuilder()->layout('backend');
	}

	public function index()
    {       
        $comments = $this->Paginator->paginate($this->Comments->find()->order(['Comments.created' => 'DESC']), ['maxLimit' => 10]);
        $this->set(compact('comments'));
    }
	
	public function add()
    {
    	if($this->Global->canComment()){
	        $comment = $this->Comments->newEntity(); 
	        if ($this->request->is('post')) {
	        	
	            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
	            
	            $comment->user_id = $this->Auth->user('id');
	            $referer_parts = explode('/',$this->request->referer());
	            $slug = end($referer_parts);

	            $articles = TableRegistry::get('Articles');            
	            $comment->article_id = $articles->findBySlug($slug)->firstOrFail()->id;

	            if($this->Auth->user('role_id') < 4){ //admin, editor, author -right away
	            	$comment->is_approved = 1;
	            	$message = 'Your comment is posted';
	            } else {
	            	$message = 'Your comment is waiting for approval';
	            }

	            if ($this->Comments->save($comment)) {
	                $this->Flash->success(__($message));
	                return $this->redirect($this->request->referer());
	            }
	            $this->Flash->error(__('Unable to add your comment.'));
	            return $this->redirect($this->request->referer());
	        }

	        $this->set('comment', $comment);
    	} else {
    		$this->Flash->error(__('Commenting disabled'));
    		return $this->redirect($this->request->referer());
    	}        
       
    }

    public function edit($id)
	{
	    $comment = $this->Comments->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	        $this->Comments->patchEntity($comment, $this->request->getData(), [    
	        	//disable modification        	
            	'accessibleFields' => ['user_id' => false, 'article_id' => false, 'answers' => false]
        	]);
        	
	        if ($this->Comments->save($comment)) {
	            $this->Flash->success(__('Your comment has been updated.'));
	            return $this->redirect($this->request->referer());
	        }
	        $this->Flash->error(__('Unable to update your comment.'));
	    }

	    $this->set('comment', $comment);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);
	    
	    $comment = $this->Comments->findById($id)->firstOrFail();
	    if ($this->Comments->delete($comment)) {
	        $this->Flash->success(__('The comment has been deleted.'));
	        if(strpos($this->request->referer(), 'edit') != false) {
	       		return $this->redirect(['action' => 'index']);
	       	} else {
	       		return $this->redirect($this->request->referer());
	       	}
	    }
	}

	public function isAuthorized($user)
	{
	    $action = $this->request->getParam('action');
	    
	    if ($action == 'add') {
	        return true;
	    }

	    if ($action == 'index' && $this->Auth->user('role_id') != 4) {
	        return true;
	    }

	    if ($action == 'edit' && $this->Auth->user('role_id') < 3) {
	        return true;
	    }

	    $id = $this->request->getParam('pass.0');
	    if (!$id) {
	        return false;
	    }

	    $comment = $this->Comments->findById($id)->first();

	    if($action == 'delete' && ($comment->user_id === $user['id'] || $this->Auth->user('role_id') < 3)){ //<3 is admin, editor
	    	return true;
		}
	}
}