
<h1>Edit Slide</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to slides', ['action' => 'index', $slide->slider_id], ['escape' => false]) ?>

<?php 
    echo $this->Form->create($slide, ['type' => 'file']);    
    echo '<img src="'.$this->request->webroot . 'webroot/uploads/' . $slide->file->preview.'" style="width:150px; height:auto;">';  
    echo $this->Form->control('image', ['type' => 'file']);
    echo $this->Form->control('image_link', ['class' => 'form-control']);
    echo $this->Form->control('text', ['type' => 'textarea', 'class' => 'form-control']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $slide->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>

