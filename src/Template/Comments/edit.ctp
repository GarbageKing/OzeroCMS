<h1>Edit Comment</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Comments', ['action' => 'index'], ['escape' => false]) ?>

<?php 
    echo $this->Form->create($comment);    
    echo $this->Form->control('body', ['class' => 'form-control']);    
    echo $this->Form->control('is_approved', ['type' => 'checkbox']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $comment->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
