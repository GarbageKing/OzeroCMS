<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class OptionsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');         
    }

    public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('value', true)
	        //->minLength('value', 1)
	        ->maxLength('value', 999);

	    return $validator;
	}
    
}