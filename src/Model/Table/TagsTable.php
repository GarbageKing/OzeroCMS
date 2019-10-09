<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\ORM\Rule\IsUnique;

use Cake\ORM\Query;

class TagsTable extends Table
{    
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');        
        $this->hasMany('Articles_Tags', [	  //we only need to delete a connection, not the article       
	        'dependent' => true, 'counterCache' => true
	    ]);	
    }

	public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('title', false)
	        ->minLength('title', 1)
	        ->maxLength('title', 191)
			->add('title', 'unique', [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Tag already exists'
             ]);

	    return $validator;
	}

	public function findUsed(Query $query, array $options)
	{ 
	    $columns = [
	        'Tags.id', 'Tags.title', 'Articles_Tags.article_id'
	    ];

	    $query = $query
	        ->select(array_merge($columns, ['amount' => 'COUNT(Articles_Tags.article_id)']))
	        ->distinct(['Tags.id']);

	    if($options['include_unused'] == 0){
	    	$query->innerJoinWith('Articles_Tags');
		} else {
			$query->leftJoinWith('Articles_Tags');
		}
	            
	    return $query->group('Tags.id');
	}

}