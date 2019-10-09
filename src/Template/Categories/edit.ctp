<h1>Edit Category</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Categories', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($category);   
    echo $this->Form->control('title', ['class' => 'form-control']);    
    
    echo $this->Form->input('parent_id', array(
        'type' => 'select',
        'options' => $categories,
        'empty' => 'Choose Parent',
        'id' => 'parent',
        'value' => $category->parent_id,
        'class' => 'form-control'
        ));   
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $category->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
