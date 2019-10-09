
<h1>Edit Article</h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to All articles', ['action' => 'all'], ['escape' => false]) ?>

<?php 
    echo $this->Form->create($article, ['type' => 'file']);    
    echo $this->Form->control('title', ['class' => 'form-control']);   
    echo $this->Form->control('description', ['class' => 'form-control']);
    echo $this->Form->control('keywords', ['class' => 'form-control']); 
    echo '<img src="'.$this->request->webroot . 'webroot/uploads/' . $article->preview.'" style="width:'.$thumb_size.'px; height:'.$thumb_size.'px;">';  
    echo $this->Form->control('preview', ['type' => 'file']);
    echo $this->Form->control('body', ['rows' => '10', 'class' => 'form-control']);
    echo $this->Form->input('tags', array(
        'type' => 'select',
        'options' => $tags,
        'empty' => 'Add Tags',
        'class' => 'form-control',
        'id' => 'tags'
    ));
    echo $this->Form->input('category_id', array(
        'type' => 'select',
        'options' => $categories,
        'empty' => 'Add To Category',
        'id' => 'category',
        'value' => $article->category_id,
        'class' => 'form-control'
    ));
    
    echo $this->Form->control('tag_string', ['type' => 'text', 'class' => 'form-control']);
    echo $this->Form->control('published', ['type' => 'checkbox']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    
    echo $this->Form->end();
?>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $article->slug],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
