<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\ORM\Rule\IsUnique;

use Cake\ORM\Query;

class CategoriesTable extends Table
{    
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp'); 
        $this->hasMany('SubCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id' 
        ]);

        $this->belongsTo('ParentCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id' 
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
                    'message' => 'Category already exists'
             ]);

	    return $validator;
	}

	public function findRelations(Query $query, array $options)
	{
	    $columns = [
	        'Categories.id', 'Categories.title'
	    ];

	    $query = $query
	        ->select($columns)	        	    
	        ->where(['Categories.id !=' => $options['this_id'], 'Categories.parent_id !=' => $options['this_id']])->orWhere(['Categories.id !=' => $options['this_id'], 
	        	'Categories.parent_id is ' => null]);
	    
	    foreach($query as $category){
	    	$arr[$category->id] = $category->title;	    	
	    }
	    
	    return $arr;
	}

}