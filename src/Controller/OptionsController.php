<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class OptionsController extends AppController
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

	public function backend()
    {       
        $options = $this->Options->find('all', [    
    		'order' => 'priority'
		]); 
        $pages = TableRegistry::get('Pages');        
        $fpages = $pages->find('list')->find('published'); 

        $this->set(compact('options'));
        $this->set(compact('fpages'));
    }
   
    public function edit($id)
	{
	    $option = $this->Options->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	    	$values = $this->request->getData(); 
	    	if($id == 1){ //meaning first page thing

	    		$values['additional'] = '';
	    		if($values['value'] != ''){
		    		$pages = TableRegistry::get('Pages');
		    		$page_name = $pages->findById($values['value'])->firstOrFail()->slug;
		    		$values['additional'] = $page_name;
	    		} 
	    	}  
	        $this->Options->patchEntity($option, $values);
        	
	        if ($this->Options->save($option)) {
	            $this->Flash->success(__('Your option has been updated.'));
	            return $this->redirect(['action' => 'backend']);
	        }
	        $this->Flash->error(__('Unable to update your option.'));
	    }
	    $this->autoRender = false;
	}

	public function customCss() {

		$mm_dir = new Folder(WWW_ROOT . 'css', true, 0755);
		$file = new File($mm_dir->pwd() . DS . 'user.css');
		
        if ($this->request->is(['post', 'put'])) {
            
            if ($file->write($this->request->getData()['usercss'])) {
            	$file->close();
                $this->Flash->success(__('Your css has been updated.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Unable to update your css.'));
        }
        $usercss = (object) ['usercss' => $file->read()];       
        $this->set('usercss', $usercss);
		
	    $file->close(); 
	}

	public function customJs() {

		$mm_dir = new Folder(WWW_ROOT . 'js', true, 0755);
		$file = new File($mm_dir->pwd() . DS . 'user.js');
		
        if ($this->request->is(['post', 'put'])) {
            
            if ($file->write($this->request->getData()['userjs'])) {
            	$file->close();
                $this->Flash->success(__('Your js has been updated.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Unable to update your js.'));
        }
        $userjs = (object) ['userjs' => $file->read()];     
        $this->set('userjs', $userjs);
		
	    $file->close(); 
	}

	public function isAuthorized($user)
	{
	    $action = $this->request->getParam('action');
	    
	    if ($action == 'backend' && $this->Auth->user('role_id') != 4) {
	        return true;
	    }

	    if (in_array($action, array('edit', 'customCss', 'customJs')) && $this->Auth->user('role_id') < 3) {
	        return true;
	    }

	    $id = $this->request->getParam('pass.0');
	    if (!$id || $this->Auth->user('role_id') > 2) {
	        return false;
	    }
	    
	}

}