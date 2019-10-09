
<h1>Edit Page</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to All pages', ['action' => 'index'], ['escape' => false]) ?>

<?php 
    echo $this->Form->create($page);    
    echo $this->Form->control('title', ['class' => 'form-control']);
    echo $this->Form->control('description', ['class' => 'form-control']);
    echo $this->Form->control('keywords', ['class' => 'form-control']);
    echo $this->Form->control('body', ['rows' => '10', 'class' => 'form-control']);
    echo $this->Form->control('published', ['type' => 'checkbox']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $page->slug],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
