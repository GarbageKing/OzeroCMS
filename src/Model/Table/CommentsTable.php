<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class CommentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');        	    
	    $this->belongsTo('Articles');	
	    $this->hasMany('AnswerComments', [
            'className' => 'Comments',
            'foreignKey' => 'answers' 
        ]);

        $this->belongsTo('ParentComments', [
            'className' => 'Comments',
            'foreignKey' => 'answers' 
        ]);
        $this->belongsTo('Users');
    }

	public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('body', false)
	        ->minLength('body', 1)
	        ->maxLength('body', 999);

	    return $validator;
	}

}