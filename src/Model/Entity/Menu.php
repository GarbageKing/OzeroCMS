<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;
use Cake\Routing\Router;

class Menu extends Entity
{
    protected $_accessible = [
        '*' => true
    ];

}