<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class PagesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp'); 
        $this->hasMany('Sliders_Pages', ['dependent' => true]);	               	
    }

    public function beforeSave($event, $entity, $options)
	{			    
	    if ($entity->isNew() && !$entity->slug) {
	        $sluggedTitle = Text::slug($entity->title);
	        // trim slug to maximum length defined in schema
	        $entity->slug = substr($sluggedTitle, 0, 191);
	    }
	}

	public function validationDefault(Validator $validator)
	{
	    $validator
	        ->allowEmptyString('title', false)
	        ->minLength('title', 1)
	        ->maxLength('title', 255)

	        ->allowEmptyString('body', false)
	        ->minLength('body', 1);

	    return $validator;
	}

	public function findPublished(Query $query)
	{
	    $columns = [
	        'Pages.id', 'Pages.user_id', 'Pages.title',
	        'Pages.body', 'Pages.published', 'Pages.created',
	        'Pages.slug'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);

	    $query->where(['Pages.published' => 1]);

	    return $query->group(['Articles.id']);
	}
	
}