<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Utility\Text;
use Cake\Event\Event;

class SlidersController extends AppController
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
        $sliders = $this->Paginator->paginate($this->Sliders->find()->order(['Sliders.created' => 'DESC']), ['maxLimit' => 20]);
        $this->set(compact('sliders'));
    }

	public function add()
    {
        $slider = $this->Sliders->newEntity(); 
        if ($this->request->is('post')) {

        	$slider = $this->Sliders->patchEntity($slider, $this->request->getData());
            
            $result = $this->Sliders->save($slider);
            if ($result) {
                $this->Flash->success(__('Your slider has been saved.'));
                return $this->redirect(['action' => 'edit', $result->id]);
            }
            $this->Flash->error(__('Unable to add your slider.'));
        }

        $pages = $this->Sliders->Pages->find('list');
        
        $this->set('slider', $slider);
        $this->set('pages', $pages);
    }

    public function edit($id)
	{
	    $slider = $this->Sliders->findById($id)->contain('Pages')->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	        $this->Sliders->patchEntity($slider, $this->request->getData());
        	
	        if ($this->Sliders->save($slider)) {
	            $this->Flash->success(__('Your slider has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update your slider.'));
	    }

	    $pages = $this->Sliders->Pages->find('list');

	    $this->set('slider', $slider);
	    $this->set('pages', $pages);
	}

	public function delete($id)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $slider = $this->Sliders->findById($id)->firstOrFail();
	    if ($this->Sliders->delete($slider)) {
	        $this->Flash->success(__('The {0} slider has been deleted.', $slider->title));
	        return $this->redirect(['action' => 'index']);
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