<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\ORM\Rule\IsUnique;

class UsersTable extends Table
{    
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');         
        $this->hasMany('Articles', [
        	'foreignKey' => 'user_id',
		    'dependent' => true,
		    'cascadeCallbacks' => true
		]);
		$this->hasMany('Pages', [
        	'foreignKey' => 'user_id',
		    'dependent' => true,
		    'cascadeCallbacks' => true
		]);
		$this->hasMany('Comments', [
        	'foreignKey' => 'user_id',
		    'dependent' => true,
		    'cascadeCallbacks' => true
		]);
		$this->belongsTo('Roles', [
	        'foreignKey' => 'role_id',
	        'dependent' => true
	    ]);	
    }

	public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('email', false)	        
	        ->maxLength('email', 255)
	        ->add('email', 'unique', [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Email is already used'
             ])
	        ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ])

	        ->allowEmptyString('password', false)
	        ->minLength('password', 6)
	        ->maxLength('password', 255)


	        ->allowEmptyString('username', false)	        
	        ->maxLength('username', 191)
	        ->add('username', 'unique', [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Username is already used'
             ]);

	    return $validator;
	}
}