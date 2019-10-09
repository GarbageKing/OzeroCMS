
<div class="row">
    <div class="col-sm-9">
        <h1>Edit Slider</h1> 
        <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to sliders', ['action' => 'index'], ['escape' => false]) ?>
    </div>
    <div class="col-sm-3 text-right">
        <?= $this->Html->link('Edit Slides', ['controller' => 'slides', 'action' => 'index', $slider->id], ['class'=>'btn btn-primary']) ?>
    </div>
</div>

<?php 
    echo $this->Form->create($slider);    
    echo $this->Form->control('title', ['class' => 'form-control']);
    echo $this->Form->control('is_slider', ['type' => 'checkbox', 'label' => 'Is a Slider (for many images)']);
    echo $this->Form->control('all_pages', ['type' => 'checkbox', 'label' => 'Display on all pages (line below will be ignored)']);
    echo $this->Form->control('pages_list', ['label' => 'Display on following pages (separated by commas)', 'class' => 'form-control']);
    echo $this->Form->control('on_articles', ['type' => 'checkbox','label' => 'Display on articles']);
    echo $this->Form->control('on_article_listings', ['type' => 'checkbox', 'label' => 'Display on article listings']);
    echo $this->Form->button(__('Save'), ['class' => 'btn btn-success mt-2']);
    echo $this->Form->end();
?>

<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $slider->id],
                        ['class' => 'btn btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>

