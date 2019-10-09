<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class MenusTable extends Table
{
   
    public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('name', false)
	        ->minLength('name', 1)
	        ->maxLength('name', 191)

	        ->allowEmptyString('url', false)
	        ->minLength('url', 1)
	        ->maxLength('url', 191);

	    return $validator;
	}
    
}