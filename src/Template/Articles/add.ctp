
<h1>Add Article</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to All articles', ['action' => 'all'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($article, ['type' => 'file']);
    
    echo $this->Form->control('title', ['class' => 'form-control']);
    echo $this->Form->control('description', ['class' => 'form-control']);
    echo $this->Form->control('keywords', ['class' => 'form-control']);
    echo '<br>';
    echo $this->Form->control('preview', ['type' => 'file']);
    echo $this->Form->control('body', ['rows' => '10', 'class' => 'form-control']);
    echo $this->Form->input('tags', array(
	    'type' => 'select',
	    'options' => $tags,
	    'empty' => 'Add Tags',
	    'id' => 'tags',
	    'class' => 'form-control'
	));    
	echo $this->Form->input('categories', array(
	    'type' => 'select',
	    'options' => $categories,
	    'empty' => 'Add To Category',
	    'id' => 'categories',
	    'class' => 'form-control'
	));  
	
    echo $this->Form->control('tag_string', ['type' => 'text', 'class' => 'form-control']);
    echo $this->Form->control('published', ['type' => 'checkbox', ['checked' => 'checked']]);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

