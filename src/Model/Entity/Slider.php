<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Slider extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'pages_list' => true        
    ];

    protected function _getPagesList()
	{
	    if (isset($this->_properties['pages_list'])) {
	        return $this->_properties['pages_list'];
	    }
	    if (empty($this->pages)) {
	        return '';
	    }
	    $pages = new Collection($this->pages);
	    $str = $pages->reduce(function ($string, $page) {
	        return $string . $page->slug . ', ';
	    }, '');
	    return trim($str, ', ');
	}
}