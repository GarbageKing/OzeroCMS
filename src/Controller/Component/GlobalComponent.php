<?php 

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;

class GlobalComponent extends Component
{

	public function startingPage()
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(1)->firstOrFail(); 
	    $value = $entry->additional;

	    $controller = 'Articles';
	    $action = 'index';
	    $post = '';
	    if($value != ''){
	        $controller = 'Pages';
	        $action = 'view';
	        $post = $value;
	    }

		return ['controller' => $controller, 'action' => $action, $post];
	}

	public function canComment()
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(2)->firstOrFail(); 
	    return $entry->value;
	}

	public function canRegister()
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(3)->firstOrFail(); 
	    return $entry->value;
	}

	public function displayArticles()
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(4)->firstOrFail(); 
	    return $entry->value;
	}

	public function thumbSize() //for articles
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(5)->firstOrFail(); 
	    return $entry->value;
	}

	public function perPage() //for articles index, category, search, tagged
	{
		$options = TableRegistry::get('Options');
	    $entry = $options->findById(13)->firstOrFail(); 
	    return $entry->value;
	}

	public function getSliderPage($id) 
	{
		$sliders = TableRegistry::get('Sliders');
		try {
			$entry = $sliders->find()->contain(['Slides' => ['Files']])->contain('Pages')->matching('Pages', function(\Cake\ORM\Query $q) use ($id) {        	
	        	try {
				    $answer = $q->where(['Pages.id' => $id]);
				} catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
				    $answer = false;
				} 
				return $answer;
	    	})->firstOrFail(); 
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
		    $entry = false;
		}		

		return $entry;
	}

	public function getSliderAllPages() {
		$sliders = TableRegistry::get('Sliders');
		try {
            $entry = $sliders->findByAllPages(1)->contain(['Slides' => ['Files']])->firstOrFail(); 
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
            $entry = false;
        }
        return $entry;
	}

	public function getSliderAllArticles() {
		$sliders = TableRegistry::get('Sliders');
		try {
            $entry = $sliders->findByOnArticles(1)->contain(['Slides' => ['Files']])->firstOrFail(); 
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
            $entry = false;
        }
        return $entry;
	}

	public function getSliderArticleListings() {
		$sliders = TableRegistry::get('Sliders');
		try {
            $entry = $sliders->findByArticleListings(1)->contain(['Slides' => ['Files']])->firstOrFail(); 
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
            $entry = false;
        }
        return $entry;
	}

    public function doUpload($file) {

		$file_name = $file['name'];
		$mm_dir = new Folder(WWW_ROOT . 'uploads', true, 0755);
            
        if(file_exists($mm_dir->pwd() . DS . $file_name)){ //instead of replacing image, rename appending time and save
        	$name_parts = explode('.', $file_name);
        	$file_name = $name_parts[0].'-'.time().'.'.$name_parts[1];
        }

        $target_path = $mm_dir->pwd() . DS . $file_name; 

        move_uploaded_file($file['tmp_name'], $target_path);

        return $file_name;
        
	}

	public function resizeImg($newWidth, $originalFile, $targetFile, $differentSides = false) {

	    $info = getimagesize($originalFile);
	    $mime = $info['mime'];

	    switch ($mime) {
	            case 'image/jpeg':
	                    $image_create_func = 'imagecreatefromjpeg';
	                    $image_save_func = 'imagejpeg';
	                    $new_image_ext = 'jpg';
	                    break;

	            case 'image/png':
	                    $image_create_func = 'imagecreatefrompng';
	                    $image_save_func = 'imagepng';
	                    $new_image_ext = 'png';
	                    break;

	            case 'image/gif':
	                    $image_create_func = 'imagecreatefromgif';
	                    $image_save_func = 'imagegif';
	                    $new_image_ext = 'gif';
	                    break;

	            case 'image/bmp':
	                    $image_create_func = 'imagecreatefrombmp';
	                    $image_save_func = 'imagebmp';
	                    $new_image_ext = 'bmp';
	                    break;

	            default: 	            		
	                    return false;	
	                    break;                    
	    }

	    $img = $image_create_func($originalFile);
	    list($width, $height) = getimagesize($originalFile);

	    if(!$differentSides){
	    	$newHeight = $newWidth; 
	    } else {
	    	$newHeight = ($height / $width) * $newWidth;
	    }
	    $tmp = imagecreatetruecolor($newWidth, $newHeight);
	    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

	    if (file_exists($targetFile)) {
	            unlink($targetFile);
	    }
	    $image_save_func($tmp, "$targetFile");
	    return true;
	}
}