<?php

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class PagesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); 
        $this->loadComponent('Global'); 
        $this->Auth->allow(['display', 'view', 'viewContact', 'emailit']);
        
    }

    public function index()
    {       
        $this->viewBuilder()->layout('backend');
        $pages = $this->Paginator->paginate($this->Pages->find(), ['maxLimit' => 10]);
        $this->set(compact('pages'));
    }

    public function view($slug = null)
    {
        $page = $this->Pages->findBySlug($slug)->firstOrFail();     
        if($page->published || ($this->Auth->user('role_id') != null && $this->Auth->user('role_id') < 4)){
            
            $this->set(compact('page'));

            $slider = $this->Global->getSliderPage($page->id);
            if(!$slider){                
                $slider = $this->Global->getSliderAllPages();                
            }

            $this->set('slider', $slider);
        } else {
            return $this->redirect($this->Global->startingPage());
        }
    }

    public function viewContact()
    {
        $page = $this->Pages->findBySlug('contact')->firstOrFail();     

        if($page->published || ($this->Auth->user('role_id') != null && $this->Auth->user('role_id') < 4)){
            $this->set(compact('page'));
        } else {
            return $this->redirect($this->Global->startingPage());
        }
    }

    public function add()
    {
        $this->viewBuilder()->layout('backend');
        $page = $this->Pages->newEntity(); 
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            
            $page->user_id = $this->Auth->user('id');

            if ($this->Pages->save($page)) {

                $slug = substr(Text::slug($page->title), 0, 191);

                $this->Flash->success(__('Your page has been saved.'));
                return $this->redirect('/page/'.$slug);
            }
            $this->Flash->error(__('Unable to add your page.'));
        }
        
        $this->set('page', $page);
    }

    public function edit($slug)
    {
        $this->viewBuilder()->layout('backend');
        $page = $this->Pages->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            
            $this->Pages->patchEntity($page, $this->request->getData(), [
                // Added: Disable modification of user_id.
                'accessibleFields' => ['user_id' => false]
            ]);
            
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('Your page has been updated.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Unable to update your page.'));
        }

        $this->set('page', $page);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        if($slug != 'contact'){

            $options = TableRegistry::get('Options');
            $first_page = $options->findById(1)->firstOrFail();
            if($first_page->additional == $slug){
                $options->patchEntity($first_page, array('value'=>'', 'additional' => ''));
                $options->save($first_page);
            }            

            $page = $this->Pages->findBySlug($slug)->firstOrFail();
            if ($this->Pages->delete($page)) {
                $this->Flash->success(__('The {0} page has been deleted.', $page->title));
                return $this->redirect(['controller' => 'pages', 'action' => 'index']);
            }
        } else {
            $this->Flash->error(__('This page can not be deleted'));
            return $this->redirect(['controller' => 'pages', 'action' => 'index']);
        }
    }

    public function emailit()
    {
        if ($this->request->is(['post'])) {
            $data = $this->request->getData();

            $options = TableRegistry::get('Options');
            $allowed = $options->findById(16)->firstOrFail();
            if($allowed->additional == 1){

                $email = new Email();
                $email->setTo($allowed->value);
                $email->setFrom($data['email'], $data['name']);           
                if($email->send($data['message'])){
                    $this->Flash->success(__('Email successfully sent'));
                    return $this->redirect($this->request->referer());
                } else {
                    $this->Flash->error(__('Email could not be sent'));
                    return $this->redirect($this->request->referer());
                }

            } else {
                $this->Flash->error(__('Email sending is currently not allowed'));
                return $this->redirect($this->request->referer());
            }
        }
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        
        if (($action == 'add' || $action == 'index') && $this->Auth->user('role_id') != 4) {
            return true;
        }

        // All other actions require a slug.
        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        // Check that the article belongs to the current user.
        $page = $this->Pages->findBySlug($slug)->first();

        if($page->user_id === $user['id'] || $this->Auth->user('role_id') < 3){ //<3 is admin, editor
            return true;
        }
    }
}
