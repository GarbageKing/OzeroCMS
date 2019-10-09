<h1>Add File</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Files', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($file, ['type' => 'file']);
    
    echo $this->Form->control('file_name', ['type' => 'file']);
    echo $this->Form->control('title', ['label' => 'Description', 'class' => 'form-control']);    
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

