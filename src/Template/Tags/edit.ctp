<h1>Edit Tag</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Tags', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($tag);   
    echo $this->Form->control('title', ['class' => 'form-control']);    
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $tag->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>