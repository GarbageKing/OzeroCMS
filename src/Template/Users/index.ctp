<div class="row mt-3">
    
    <div class="col-6">
        <h1>Users</h1>
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
                <th>Username</th>
                <th>Email</th>
                <th>Created</th>
            </tr>

            <?php foreach ($users as $user){ ?>
            <tr>
                <td>
                    <?= $this->Html->link($user->username, ['action' => 'edit', $user->id]) ?>
                </td>
                <td>
                    <?= $this->Html->link($user->email, ['action' => 'edit', $user->id]) ?>
                </td>
                <td>
                    <?= $user->created->format('d-m-Y') ?>
                </td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $user->id], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $user->id],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>

         <?= $this->element('pagination') ?>
    </div>
</div>