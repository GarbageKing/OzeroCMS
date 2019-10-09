<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;
use Cake\Routing\Router;

class Option extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'name' => false,
        'priority' => false
    ];

}