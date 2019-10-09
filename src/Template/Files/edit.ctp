<h1>Edit File</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Files', ['action' => 'index'], ['escape' => false]) ?>

<?php
    echo $this->Form->create($file, ['type' => 'file']);    
    echo '<img src="'.$this->request->webroot . 'webroot/uploads/' . $file->file_name.'">'; 
    echo $this->Form->control('title', ['label' => 'Description', 'class' => 'form-control']);    
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $file->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
