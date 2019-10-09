<?php

namespace App\Model\Table;

use Cake\Validation\Validator;

use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\Query;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp'); 
        $this->belongsToMany('Tags', [
	        'joinTable' => 'articles_tags',
	        'dependent' => true
	    ]);	    

	    $this->belongsTo('Categories');	

	    $this->hasMany('Comments', [
	    	'dependent' => true,
		    'cascadeCallbacks' => true
			])
            ->setConditions(['Comments.is_approved' => 1]);
        $this->hasMany('UnapprovedComments', [
                'className' => 'Comments',
                'dependent' => true,
		    	'cascadeCallbacks' => true
            ])
            ->setConditions(['is_approved' => 0])
            ->setProperty('unapproved_comments');
    }

    public function beforeSave($event, $entity, $options)
	{
		if ($entity->tag_string) {
	        $entity->tags = $this->_buildTags($entity->tag_string);
	    }

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

	// The $query argument is a query builder instance.
	// The $options array will contain the 'tags' option we passed
	// to find('tagged') in our controller action.
	public function findTagged(Query $query, array $options)
	{
	    $columns = [
	        'Articles.id', 'Articles.user_id', 'Articles.title',
	        'Articles.body', 'Articles.published', 'Articles.created',
	        'Articles.slug','Articles.preview', 'Categories.title'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);

	    if (empty($options['tags'])) {
	        // If there are no tags provided, find articles that have no tags.
	        $query->leftJoinWith('Tags')
	            ->where(['Tags.title IS' => null]);
	    } else {
	        // Find articles that have one or more of the provided tags.
	        $query->innerJoinWith('Tags')
	            ->where(['Tags.title IN' => $options['tags']]);
	    }
	    $query->where(['Articles.published' => 1]);

	    $query->leftJoinWith('Categories');
	            //->where(['Articles.category_id' => 'Categories.id']);

	    return $query->group(['Articles.id']);
	}

	public function findCategorized(Query $query, array $options)
	{
	    $columns = [
	        'Articles.id', 'Articles.user_id', 'Articles.title',
	        'Articles.body', 'Articles.published', 'Articles.created',
	        'Articles.slug','Articles.preview'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);

	    if (empty($options['category'])) {
	        
	        $query->leftJoinWith('Categories')
	            ->where(['Categories.title IS' => null]);
	    } else {
	       
	        $query->innerJoinWith('Categories')
	            ->where(['Categories.title IN' => $options['category']]);
	    }
	    $query->where(['Articles.published' => 1]);

	    return $query->group(['Articles.id']);
	}

	public function findSearched(Query $query, array $options)
	{
	    $columns = [
	        'Articles.id', 'Articles.user_id', 'Articles.title',
	        'Articles.body', 'Articles.published', 'Articles.created',
	        'Articles.slug','Articles.preview', 'Categories.title'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);
	    
	    if (!empty($options['query'])) { 
	   
	        $all_queries = explode(' ', trim($options['query'][0])); 

	        $query->where([
		        "MATCH(Articles.title, Articles.body) AGAINST(:search)" 
		    ])->bind(":search", $all_queries[0]);
		    
	        if(count($all_queries) > 1){
	        	array_shift($all_queries); 
	        	
	        	foreach($all_queries as $iter=>$query_str){  

	        		$query->orWhere([
				        "MATCH(Articles.title, Articles.body) AGAINST(:search$iter)" 
				    ])->bind(":search$iter", $query_str);
				    
	        	}
			}
	    }
	    $query->leftJoinWith('Categories');
	    $query->where(['Articles.published' => 1]);

	    return $query->group(['Articles.id']);
	}

	protected function _buildTags($tagString)
	{
	    // Trim tags
	    $newTags = array_map('trim', explode(',', $tagString));
	    // Remove all empty tags
	    $newTags = array_filter($newTags);
	    // Reduce duplicated tags
	    $newTags = array_unique($newTags);

	    $out = [];
	    $query = $this->Tags->find()
	        ->where(['Tags.title IN' => $newTags]);

	    // Remove existing tags from the list of new tags.
	    foreach ($query->extract('title') as $existing) {
	        $index = array_search($existing, $newTags);
	        if ($index !== false) {
	            unset($newTags[$index]);
	        }
	    }
	    // Add existing tags.
	    foreach ($query as $tag) {
	        $out[] = $tag;
	    }
	    // Add new tags.
	    foreach ($newTags as $tag) {
	        $out[] = $this->Tags->newEntity(['title' => $tag]);
	    }
	    return $out;
	}

	public function findPublished(Query $query)
	{
	    $columns = [
	        'Articles.id', 'Articles.user_id', 'Articles.title',
	        'Articles.body', 'Articles.published', 'Articles.created',
	        'Articles.slug','Articles.preview', 'Categories.title'
	    ];

	    $query = $query
	        ->select($columns)
	        ->distinct($columns);

	    $query->where(['Articles.published' => 1]);

	    $query->leftJoinWith('Categories');
	            //->where(['Articles.category_id' => 'Categories.id']);

	    return $query->group(['Articles.id']);
	}
}