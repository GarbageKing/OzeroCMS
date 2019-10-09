<?php
namespace App\View\Helper;
 
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
 
class CustomHelper extends Helper {

    public function showSidebar()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(6)->firstOrFail(); 
	    return $entry->value;
    }

    public function topLinks()
    {       
        $menu = TableRegistry::get('Menus');
        return $menu->findByPlacement(0);
    }

    public function sideLinks()
    {       
        $menu = TableRegistry::get('Menus');
        return $menu->findByPlacement(1);
    }

    public function bottomLinks()
    {       
        $menu = TableRegistry::get('Menus');
        return $menu->findByPlacement(2);
    }

    public function footerText()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(7)->firstOrFail(); 
	    return $entry->value;
    }

    public function recentPosts()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(8)->firstOrFail(); 
	    if($entry->value == 1){
	    	$articles = TableRegistry::get('Articles');
	    	$recent = $articles->find('published')->contain('Categories')->order(['Articles.created' => 'DESC'])->limit($entry->additional);
	    } else {
            $recent = false;
        }
	    return $recent;
    }

    public function recentComments()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(9)->firstOrFail(); 
	    if($entry->value == 1){
	    	$comments = TableRegistry::get('Comments');
	    	$recent = $comments->find('all', [
        	'conditions' => ['is_approved' => 1]])->contain('Users')->contain(['Articles' => ['Categories']])->order(['Comments.created' => 'DESC'])->limit($entry->additional);
	    } else {
            $recent = false;
        }
	    return $recent;
    }

    public function tagCloud()
    {      
    	
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(10)->firstOrFail(); 
	    if($entry->value == 1){
	    	$tags = TableRegistry::get('Tags');
	    	
	    	$show = $tags->find('used', ['include_unused' => $entry->additional]);
	    } else {
            $show = false;
        }
	    return $show;
    }

    public function customWidget()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(11)->firstOrFail(); 
	    return $entry->value;
    }

    public function siteName()
    {       
        $options = TableRegistry::get('Options');
	    $entry = $options->findById(12)->firstOrFail(); 
	    return $entry->value;
    }

    public function containerType()
    {       
        $options = TableRegistry::get('Options');
        $entry = $options->findById(14)->firstOrFail(); 
        return $entry->value;
    }

    public function footerBottom()
    {       
        $options = TableRegistry::get('Options');
        $entry = $options->findById(15)->firstOrFail(); 
        return $entry->value;
    }
}
