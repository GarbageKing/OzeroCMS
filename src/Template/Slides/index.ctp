<div class="row mt-3">
    
    <div class="col-6">
        <h1>Slides</h1>
        <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to slider', ['controller'=> 'sliders', 'action' => 'edit', $slider_id], ['escape'              => false]) ?> 
    </div> 
    
    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>        
        <?= $this->Html->link('Add New', ['action' => 'add', $slider_id], ['class' => 'btn btn-success']) ?>
    </div>


    <div class="col-12">
        <table>
            <tr>
                <th>Preview</th>
                <th>Created</th>
            </tr>

            <?php foreach ($slides as $slide){  ?>
            <tr>
                <td>
                    <a href="<?= $this->request->webroot . 'slides/edit/' . $slide->id ?>">                   
                    <img src="<?= $this->request->webroot . 'webroot/uploads/' . $slide->_matchingData['Files']->preview; ?>" style="width:150px; height:auto"> 
                    </a>
                </td>
                <td>
                    <?= $slide->created->format('d-m-Y') ?>
                </td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $slide->id], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $slide->id],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>
         <?= $this->element('pagination') ?>
    </div>
</div>