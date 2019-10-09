<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class FilesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');    
        $this->hasOne('Slides', ['dependent' => true, 'cascadeCallbacks' => true]);   
    }

	public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('file_name', false)
	        ->minLength('file_name', 3)
	        ->maxLength('file_name', 191);

	    return $validator;
	}

}