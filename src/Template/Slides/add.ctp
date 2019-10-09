
<h1>Add Slide</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to slides', ['action' => 'index', $slider_id], ['escape' => false]) ?>

<?php
    echo $this->Form->create($slide, ['type' => 'file']);
    
    echo $this->Form->control('image', ['type' => 'file']);
    echo $this->Form->control('image_link', ['class' => 'form-control']);
    echo $this->Form->control('text', ['type' => 'textarea', 'class' => 'form-control']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

