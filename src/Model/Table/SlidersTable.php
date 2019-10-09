<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\ORM\Rule\IsUnique;

use Cake\ORM\Query;

class SlidersTable extends Table
{    
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp'); //did this in db itself already        
        $this->hasMany('Slides', [    
	        'dependent' => true
	    ]);	
	    $this->belongsToMany('Pages', [
	        'joinTable' => 'sliders_pages',
	        'dependent' => true
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
                    'message' => 'Name already exists'
            ]);	        
	       
	    return $validator;
	}

	public function beforeSave($event, $entity, $options)
	{
		if ($entity->pages_list) {
	        $entity->pages = $this->_buildPages($entity->pages_list);
	    } else {
	    	$entity->pages = '';
	    }
	}

	protected function _buildPages($pagesString)
	{
	    
	    $allPages = array_map('trim', explode(',', $pagesString));
	    
	    $allPages = array_filter($allPages);
	    
	    $allPages = array_unique($allPages);

	    $out = [];
	    $query = $this->Pages->find()
	        ->where(['Pages.slug IN' => $allPages]);

	    foreach ($query as $page) {
	        $out[] = $page;
	    }
	    
	    return $out;
	}

	public function findPage(Query $query, array $options)
	{
	    $columns = [
	        'Sliders.id', 'Sliders.is_slider', 'Slides.file_id',
	        'Slides.text', 'Files.file_name'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);

	    $query->innerJoinWith('Sliders_Pages')
	            ->where(['Sliders_Pages.slider_id' => 'Sliders.id']);

	    $query->innerJoinWith('Slides')
	            ->where(['Slides.slider_id' => 'Sliders.id']);

	    $query->innerJoinWith('Files')
	            ->where(['Slides.file_id' => 'Files.id']);
	    
	    $query->where(['Sliders_Pages.page_id' => $options['id']]);
	    $query->where(['Sliders.all_pages' => 0]);

	    return $query->group(['Sliders.id']);
	}
}