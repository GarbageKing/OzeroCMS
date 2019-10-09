<div class="row mt-3">
    <div class="col-6">
        <h1>Comments</h1>
    </div> 

    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>        
    </div>
    
    <div class="col-12">
        <table>
            <tr>                
                <th>Text</th>
                <th>Created</th>
            </tr>

            <?php foreach ($comments as $comment){ ?>
            <tr>
                
                <td>
                    <?= $this->Html->link(mb_substr($comment->body,0,20), ['action' => 'edit', $comment->id]) ?>
                </td>
                <td>
                    <?= $comment->created->format('d-m-Y') ?>
                </td>
                <?php if ($this->Session->read('Auth.User')){ ?>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $comment->id], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $comment->id],
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