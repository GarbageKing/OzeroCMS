
<h1>Add Page</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to All pages', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($page);
    
    echo $this->Form->control('title', ['class' => 'form-control']);
    echo $this->Form->control('description', ['class' => 'form-control']);
    echo $this->Form->control('keywords', ['class' => 'form-control']);
    echo $this->Form->control('body', ['rows' => '10', 'class' => 'form-control']);    
    echo $this->Form->control('published', ['type' => 'checkbox', ['checked' => 'checked']]);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

