<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;
use Cake\Routing\Router;

class Page extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false        
    ];

}