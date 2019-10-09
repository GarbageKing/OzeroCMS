<div class="row mt-3">
    <div class="col-6">
        <h1>Pages</h1>
    </div> 
    
    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>
        <?php if ($this->Session->read('Auth.User')){ ?>
        <?= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    
    <div class="col-12">
        <table>
            <tr>                
                <th>Title</th>
                <th>Created</th>
            </tr>

            <?php foreach ($pages as $page){ 
            
            ?>
            <tr>
                <td>                   
                    <?= $this->Html->link($page->title, ['action' => 'view', $page->title]) ?>                                                     
                </td>
                
                <td>
                    <?= $page->created->format('d-m-Y h:i:s') ?>
                </td>
                <?php if ($this->Session->read('Auth.User')){ ?>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $page->title], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $page->title],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>

         <?= $this->element('pagination') ?>
    </div>
</div>