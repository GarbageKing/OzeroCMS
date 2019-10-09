<h1>Add Category</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Categories', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($category);    
    echo $this->Form->control('title', ['class' => 'form-control']);   
    echo $this->Form->input('parent_id', array(
        'type' => 'select',
        'options' => $categories,
        'empty' => 'Choose Parent',
        'id' => 'parent',
        'class' => 'form-control'
    )); 
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>