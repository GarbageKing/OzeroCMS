<?php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Event\Event;

class ArticlesController extends AppController
{

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); 
        $this->loadComponent('Global'); 
        $this->Auth->allow(['display', 'view', 'index', 'tags', 'category', 'search', 'searchQuery']);
    }

	public function index()
    {       
        $articles = $this->Paginator->paginate($this->Articles->find('published')->order(['Articles.created' => 'DESC']), ['maxLimit' => $this->Global->perPage()]); 
        $display = $this->Global->displayArticles(); 
        $thumb_size = $this->Global->thumbSize();
        $this->set(compact('articles'));
        $this->set('display', $display);
        $this->set('thumb_size', $thumb_size);

        $slider = $this->Global->getSliderArticleListings();                
            
        $this->set('slider', $slider);
    }

    public function all()
    {       
    	$this->viewBuilder()->layout('backend');
        $articles = $this->Paginator->paginate($this->Articles->find()->contain('Categories')->order(['Articles.created' => 'DESC']), ['maxLimit' => 10]);
        $thumb_size = $this->Global->thumbSize();
        $this->set(compact('articles'));
        $this->set('thumb_size', $thumb_size);
    }

    public function view($slug = null) 
	{
		
	    $article = $this->Articles->findBySlug($slug)->contain(['Tags'])->contain(['Categories' => ['ParentCategories']])
	    ->contain(['Comments' => ['Users', 'ParentComments' => 'Users']])->firstOrFail();	  
	   	    
	    if($article->published || ($this->Auth->user('role_id') != null && $this->Auth->user('role_id') < 4)){
           	$this->set(compact('article'));

		    $comments_tab = TableRegistry::get('Comments');

		    $comment = $comments_tab->newEntity();
		    
		    $this->set('comment', $comment);

		    $slider = $this->Global->getSliderAllArticles();                
            
            $this->set('slider', $slider);
        } else {
            return $this->redirect($this->Global->startingPage());
        }	    	
	    	    
	}

	public function add()
    {
    	$this->viewBuilder()->layout('backend');
        $article = $this->Articles->newEntity(); 
        if ($this->request->is('post')) {


            $article = $this->Articles->patchEntity($article, $this->request->getData());

            if($this->request->data['preview'] != null && $this->request->data['preview']['tmp_name'] != ''){
	        	$preview = $this->request->data['preview'];

	        	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);  

	        	$file_name = $this->Global->doUpload($preview);     	

	        	$target_path = $mm_dir->pwd() . DS . $file_name;

	        	$this->Global->resizeImg($this->Global->thumbSize(), $target_path, $target_path);

	        	$article->preview = $file_name;
        	}
            
            $article->user_id = $this->Auth->user('id');
            
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'view', substr(Text::slug($article->title), 0, 191)]); //would be too long to make url cute
            }
            $this->Flash->error(__('Unable to add your article.'));
        }

        $tags = $this->Articles->Tags->find('list');
        $categories = $this->Articles->Categories->find('list');

        // Set tags to the view context
        $this->set('tags', $tags);
        $this->set('categories', $categories);
        
        $this->set('article', $article);
    }

    public function edit($slug)
	{
		$this->viewBuilder()->layout('backend');
	    $article = $this->Articles->findBySlug($slug)->contain('Tags')->contain('Categories')->firstOrFail();
	    if ($this->request->is(['post', 'put'])) {
	    	
	        $this->Articles->patchEntity($article, $this->request->getData(), [            	
            	'accessibleFields' => ['user_id' => false]
        	]);
        	
        	if($this->request->data['preview'] == null || $this->request->data['preview']['tmp_name'] == ''){
        		unset($article->preview);
        	} else {
        		$preview = $this->request->data['preview'];

	        	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);  

	        	$file_name = $this->Global->doUpload($preview);     	

	        	$target_path = $mm_dir->pwd() . DS . $file_name;

	        	$this->Global->resizeImg($this->Global->thumbSize(), $target_path, $target_path);

	        	$article->preview = $file_name;
        	}
	        if ($this->Articles->save($article)) {
	            $this->Flash->success(__('Your article has been updated.'));
	            return $this->redirect($this->referer());
	        }
	        $this->Flash->error(__('Unable to update your article.'));
	    }

	    // Get a list of tags.
	    $tags = $this->Articles->Tags->find('list');
	    $categories = $this->Articles->Categories->find('list'); 
	    $thumb_size = $this->Global->thumbSize();
	    	    
	    // Set tags to the view context
	    $this->set('tags', $tags);
	    $this->set('categories', $categories);

	    $this->set('article', $article);
	    
	    $this->set('thumb_size', $thumb_size);
	}

	public function delete($slug)
	{
	    $this->request->allowMethod(['post', 'delete']);

	    $article = $this->Articles->findBySlug($slug)->contain(['Tags'])->contain('Categories')->firstOrFail();
	    $preview = $article->preview;
	    
	    if ($this->Articles->delete($article)) {

	    	if($preview != null && $preview != ''){
	    		unlink(WWW_ROOT . 'uploads' . DS . $preview);
	    	}

	        $this->Flash->success(__('The {0} article has been deleted.', $article->title));
	        return $this->redirect(['action' => 'all']);
	    }
	}

	public function tags()
	{
	    // The 'pass' key is provided by CakePHP and contains all
	    // the passed URL path segments in the request.
	    $tags = $this->request->getParam('pass');
	    
	    $articles = $this->Paginator->paginate($this->Articles->find('tagged', [
	        'tags' => $tags
	    ])->order(['Articles.created' => 'DESC']), ['maxLimit' => $this->Global->perPage()]);

	    // Pass variables into the view template context.
	    $this->set([
	        'articles' => $articles,
	        'tags' => $tags
	    ]);

	    $slider = $this->Global->getSliderArticleListings();                
            
        $this->set('slider', $slider);
	}

	public function category()
	{
	    // The 'pass' key is provided by CakePHP and contains all
	    // the passed URL path segments in the request.
	    $category = $this->request->getParam('pass');

	    $articles = $this->Paginator->paginate($this->Articles->find('categorized', [
	        'category' => $category
	    ])->order(['Articles.created' => 'DESC']), ['maxLimit' => $this->Global->perPage()]);

	    $categories = TableRegistry::get('Categories');            
            
	    $category = $categories->findByTitle($category[0])->contain(['ParentCategories'])->firstOrFail();	  

	    $this->set([
	        'articles' => $articles,
	        'category' => $category
	    ]);

	    $slider = $this->Global->getSliderArticleListings();                
            
        $this->set('slider', $slider);
	}

	public function searchQuery()
	{
		$this->redirect(['action' => 'search', $this->request->getData()['search']]);
	}

	public function search()
	{
	    // The 'pass' key is provided by CakePHP and contains all
	    // the passed URL path segments in the request.
	    $query = $this->request->getParam('pass');

	    $articles = $this->Paginator->paginate($this->Articles->find('searched', [
	        'query' => $query
	    ])->order(['Articles.created' => 'DESC']), ['maxLimit' => $this->Global->perPage()]);

	    $this->set([
	        'articles' => $articles,
	        'search' => trim($this->request->getParam('pass')[0])        
	    ]);

	    $slider = $this->Global->getSliderArticleListings();                
            
        $this->set('slider', $slider);
	}

	public function uploadFiles() {

		
	    if ($this->request->is('post')) { 
            
            $file = $this->request->data['file'];            

            $new_file = $this->Global->doUpload($file);  

            if($new_file){    
               	echo $new_file;

               	$file_parts = explode('.', $new_file);

               	$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755); 

               	$orig_path = $mm_dir->pwd() . DS . $new_file;
	        	$target_path = explode('.', $orig_path);
	        	$preview = $target_path[0].'-thumb.'.$target_path[1];

	        	$this->Global->resizeImg(150, $orig_path, $preview, true);

               	$files = TableRegistry::get('Files');

               	$file = $files->newEntity(array("file_name"=>$new_file, "preview"=>$file_parts[0].'-thumb.'.$file_parts[1]));
				$files->save($file);	   			
        	}
            
            
	    }
	    $this->autoRender = false; //no need in a view
	}

	public function isAuthorized($user)
	{
	    $action = $this->request->getParam('action');
	    
	    if (($action == 'add' || $action == 'uploadFiles' || $action == 'all') && $this->Auth->user('role_id') != 4) {
	        return true;
	    }

	    // All other actions require a slug.
	    $slug = $this->request->getParam('pass.0');
	    if (!$slug) {
	        return false;
	    }

	    // Check that the article belongs to the current user.
	    $article = $this->Articles->findBySlug($slug)->first();

	    if($article->user_id === $user['id'] || $this->Auth->user('role_id') < 3){ //<3 is admin, editor
	    	return true;
		}
	}
}