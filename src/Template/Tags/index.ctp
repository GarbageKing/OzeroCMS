<div class="row mt-3">
    
    <div class="col-6">
        <h1>Tags</h1>
    </div> 
    
    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>        
        <?= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
    </div>


    <div class="col-12">
        <table>
            <tr>
                <th>Title</th>
                <th>Created</th>
            </tr>

            <?php foreach ($tags as $tag){ ?>
            <tr>
                <td>
                    <?= $this->Html->link($tag->title, ['action' => 'edit', $tag->id]) ?>
                </td>
                <td>
                    <?= $tag->created->format('d-m-Y') ?>
                </td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $tag->id], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $tag->id],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?= $this->element('pagination') ?>
    </div>
</div>