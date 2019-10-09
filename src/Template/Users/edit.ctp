<h1>Edit User</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Users', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($user);  
    echo $this->Form->control('username', ['class' => 'form-control']);  
    echo $this->Form->control('email', ['class' => 'form-control']);    
    echo $this->Form->control('password', ['class' => 'form-control']);    
    echo $this->Form->control('role_id', ['class' => 'form-control']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $user->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>