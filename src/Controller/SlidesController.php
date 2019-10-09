<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class SlidesController extends AppController
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

	public function index($slider_id)
    {       
        $slides = $this->Paginator->paginate($this->Slides->find('slider', ['slider_id' => $slider_id])->order(['Slides.created' => 'DESC']), ['maxLimit' => 20]);
        $this->set(compact('slides'));
        $this->set('slider_id', $slider_id);
    }

	public function add($slider_id)
    {    	
        $slide = $this->Slides->newEntity(); 
        if ($this->request->is('post')) {

            $slide = $this->Slides->patchEntity($slide, $this->request->getData());
            $slide->slider_id = $slider_id;
            $files = TableRegistry::get('Files');
	        //make only if there is file I guess alternative is to use already uploaded image 
	       
	        if($this->request->data['image'] != null && $this->request->data['image']['tmp_name'] != ''){
	        	$file_add = $this->request->data['image']; 

	        	$file_name = $this->Global->doUpload($file_add);    

	        	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);  	

	        	$orig_path = $mm_dir->pwd() . DS . $file_name;
	        	$target_path = explode('.', $orig_path);
	        	$preview = $target_path[0].'-thumb.'.$target_path[1];

	        	$thumb = $this->Global->resizeImg(150, $orig_path, $preview, true);
	            
	            if($thumb){
		            $pre_parts = explode('\\', $preview);
		            $preview = end($pre_parts);
	        	}
	        	
	           	$file = $files->newEntity(array("file_name"=>$file_name, "preview"=>$preview));
				$result = $files->save($file);
				if ($result) {
					$slide->file_id = $result->id;
				}
			} else if($this->request->data['image_link'] != null && $this->request->data['image_link'] != '') {
				$name = explode('/', $this->request->data['image_link']);
				$rname = array_pop($name);

				$slide->file_id = $files->findByFileName($rname)->firstOrFail()->id;
			} else {
				 $this->Flash->error(__('No image included'));
			}
			
            if ($this->Slides->save($slide)) {
                $this->Flash->success(__('Your slide has been saved.')); 
                return $this->redirect(['action' => 'index', $slider_id]); //would be too long to make url cute
            }
            $this->Flash->error(__('Unable to add your slide.'));
        }

        $this->set('slide', $slide);
        $this->set('slider_id', $slider_id);
    }

    public function edit($id)
	{
	    $slide = $this->Slides->findById($id)->contain('Files')->firstOrFail();
        if ($this->request->is(['post', 'put'])) {

            $slide = $this->Slides->patchEntity($slide, $this->request->getData());
            $files = TableRegistry::get('Files');
	        //make only if there is file I guess alternative is to use already uploaded image 
	        
	        if($this->request->data['image'] != null && $this->request->data['image']['tmp_name'] != ''){
	        	$file_add = $this->request->data['image']; 

	        	$file_name = $this->Global->doUpload($file_add);    

	        	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);  	

	        	$orig_path = $mm_dir->pwd() . DS . $file_name;
	        	$target_path = explode('.', $orig_path);
	        	$preview = $target_path[0].'-thumb.'.$target_path[1];

	        	$thumb = $this->Global->resizeImg(150, $orig_path, $preview, true);
	            
	            if($thumb){
		            $pre_parts = explode('\\', $preview);
		            $preview = end($pre_parts);
	        	}
	        	
	           	$file = $files->newEntity(array("file_name"=>$file_name, "preview"=>$preview));
				$result = $files->save($file);
				if ($result) {
					$slide->file_id = $result->id;
				}
			} else if($this->request->data['image_link'] != null && $this->request->data['image_link'] != '') {
				$name = explode('/', $this->request->data['image_link']);
				$rname = array_pop($name);

				$slide->file_id = $files->findByFileName($rname)->firstOrFail()->id;
			}
			
            if ($this->Slides->save($slide)) {
                $this->Flash->success(__('Your slide has been updated.')); 
                return $this->redirect(['action' => 'index', $slide->slider_id]); //would be too long to make url cute
            }
            $this->Flash->error(__('Unable to update your slide.'));
        }

        $this->set('slide', $slide);        
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $slide = $this->Slides->findById($id)->firstOrFail();
	    if ($this->Slides->delete($slide)) {
	        $this->Flash->success(__('The slide has been deleted.'));
	        return $this->redirect(['action' => 'index', $slide->slider_id]);
	    }
	}
		
	public function isAuthorized($user)
	{
	    
	    if ($this->Auth->user('role_id') < 3) {
	        return true;
	    } else {
	    	return false;
	    }

	}
}