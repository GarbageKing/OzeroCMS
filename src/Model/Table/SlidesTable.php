<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\ORM\Rule\IsUnique;

use Cake\ORM\Query;

class SlidesTable extends Table
{    
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');        
        $this->belongsTo('Sliders');        
        $this->belongsTo('Files');
    }

	public function validationDefault(Validator $validator)
	{
	    $validator	          
	    	->allowEmptyString('text', true)
	        ->maxLength('text', 999);

	    return $validator;
	}

	public function findSlider(Query $query, array $options)
	{
	    $columns = [
	        'Slides.id', 'Slides.slider_id', 'Slides.file_id',
	        'Slides.text', 'Slides.created', 'Files.preview'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns)

	        ->where(['Slides.slider_id' => $options['slider_id']]);
	    
	    $query->innerJoinWith('Files');
	            

	    return $query->group(['Slides.id']);
	}

}