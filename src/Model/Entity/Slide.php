<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Slide extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false        
    ];
}