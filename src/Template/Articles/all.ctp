
<div class="row mt-3">
    <div class="col-6">
        <h1>Articles</h1>
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
                <th style="width:<?= $thumb_size+20 ?>px;">Preview</th> <!--preview size + 20-->
                <th>Title</th>
                <th></th>
                <th>Created</th><?php //echo $this->Paginator->sort('created', 'Created'); ?>
                <th>Actions</th>
                <th>Status</th>
            </tr>

            <!-- Here is where we iterate through our $articles query object, printing out article info -->

            <?php foreach ($articles as $article){ 
            if($article->category != null && $article->category != ''){
                $category = $article->category->title;
            } else {
                $category = 'view';
            }
            ?>
            <tr>
                <td>    
                    <a href="<?= $this->request->webroot . 'articles/' . $category . '/' . $article->slug ?>">
                    <?php if($article->preview != null && $article->preview != ''){ ?>
                    <img src="<?= $this->request->webroot . 'webroot/uploads/' . $article->preview; ?>" style="width:<?= $thumb_size ?>px; height:<?= $thumb_size ?>px;">
                    <?php } else { ?>
                        <i class="fas fa-book-open fa-3x" style="width:<?= $thumb_size ?>px; height:<?= $thumb_size ?>px;"></i>
                    <?php } ?>
                    </a>                                     
                </td>
                <td>
                    <?= $this->Html->link($article->title, ['action' => $category, $article->slug]) ?>
                </td>
                <td>
                    <?= mb_substr(strip_tags(str_replace('>', '> ', $article->body)), 0, 50) ?>
                </td>
                <td>
                    <?= $article->created->format('d-m-Y h:i:s') ?>
                </td>
                <?php if ($this->Session->read('Auth.User')){ ?>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $article->slug], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $article->slug],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
                <td>
                    <?php if($article->published == 1){?>
                    <i class="fas fa-eye"></i>
                    <?php } else { ?>
                    <i class="fas fa-eye-slash"></i>
                    <?php } ?>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>

         <?= $this->element('pagination') ?>
    </div>
</div>