<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Event\Event;

class FilesController extends AppController
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
        $files = $this->Paginator->paginate($this->Files->find()->order(['Files.created' => 'DESC']), ['maxLimit' => 20]);
        $this->set(compact('files'));
    }

	public function add()
    {
        $file = $this->Files->newEntity(); 
        if ($this->request->is('post')) {

        	$file_add = $this->request->data['file_name'];

        	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);  

        	$file_name = $this->Global->doUpload($file_add);     	

        	$orig_path = $mm_dir->pwd() . DS . $file_name;
        	$target_path = explode('.', $orig_path);
        	$preview = $target_path[0].'-thumb.'.$target_path[1];

        	$thumb = $this->Global->resizeImg(150, $orig_path, $preview, true);

            $file = $this->Files->patchEntity($file, $this->request->getData());

            $file->file_name = $file_name;
            
            if($thumb){
	            $pre_parts = explode('\\', $preview);
	            $file->preview = end($pre_parts);
        	}
        	            
            if ($this->Files->save($file)) {
                $this->Flash->success(__('Your file has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your file.'));
        }
        
        $this->set('file', $file);
    }

    public function edit($id)
	{
	    $file = $this->Files->findById($id)->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	        $this->Files->patchEntity($file, $this->request->getData());
        	
	        if ($this->Files->save($file)) {
	            $this->Flash->success(__('Your file has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update your file.'));
	    }

	    $this->set('file', $file);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $file = $this->Files->findById($id)->firstOrFail();
	    $preview = $file->preview;
	    $file_name = $file->file_name;
	    
	    if ($this->Files->delete($file)) {

	    	if($preview != null && $preview != ''){
	    		unlink(WWW_ROOT . 'uploads' . DS . $preview);
	    	}
	    	if($file_name != null && $file_name != ''){
	    		unlink(WWW_ROOT . 'uploads' . DS . $file_name);
	    	}

	        $this->Flash->success(__('The {0} file has been deleted.', $file->file_name));
	        return $this->redirect(['action' => 'index']);
	    }
	}
		
	public function isAuthorized($user)
	{
			    
	    if ($this->Auth->user('role_id') < 4) {
	        return true;
	    } else {
	    	return false;
	    }

	}
}