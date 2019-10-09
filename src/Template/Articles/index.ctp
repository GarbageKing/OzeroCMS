<?= $this->element('slider') ?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->request->webroot ?>">Home</a></li>      
            <li class="breadcrumb-item active" aria-current="page">Articles</li>                  
          </ol>
        </nav>
    </div>
    <div class="col-sm-9">        
        <h1>Articles</h1>
    </div> 
    
    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>
        <?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){  ?>
        <?= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>
    
    <div class="col-12">
        <?php if($display == 0) { ?>
        <table>
            <tr>
                <th style="width:<?= $thumb_size+20 ?>px;"></th> <!--preview size + 20-->
                <th></th>
                <th></th>
                <th></th>
            </tr>

            <?php foreach ($articles as $article){ //debug($article);
            if($article->_matchingData['Categories']->title != null){
                $category = $article->_matchingData['Categories']->title;
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
                <?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){ ?>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $article->slug], ['class'=>'btn btn-sm btn-primary']) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $article->slug],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>
        <?php } else if($display == 1) { ?>
            <div class="row">
                
                <?php foreach ($articles as $article){ 
                
                    if($article->_matchingData['Categories']->title != null){
                        $category = $article->_matchingData['Categories']->title;
                    } else {
                        $category = 'view';
                    }
                    ?>
                <div class="col-3 text-center mt-3">
                    <div>
                        <a href="<?= $this->request->webroot . 'articles/' . $category . '/' . $article->slug ?>">
                        <?php if($article->preview != null && $article->preview != ''){ ?>
                        <img src="<?= $this->request->webroot . 'webroot/uploads/' . $article->preview; ?>" style="width:<?= $thumb_size ?>px; height:<?= $thumb_size ?>px;">
                        <?php } else { ?>
                            <i class="fas fa-book-open fa-3x" style="width:<?= $thumb_size ?>px; height:<?= $thumb_size ?>px;"></i>
                        <?php } ?>
                        </a> 
                    </div>
                    <div>
                        <?= $this->Html->link($article->title, ['action' => $category, $article->slug]) ?>
                    </div> 
                    <div>
                        <?= mb_substr(strip_tags(str_replace('>', '> ', $article->body)), 0, 50) ?>
                    </div>
                    <div>                   
                        <?= $article->created->format('d-m-Y h:i:s') ?>
                    </div>
                    <?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){ ?>
                    
                        <?= $this->Html->link('Edit', ['action' => 'edit', $article->slug], ['class'=>'btn btn-sm btn-primary']) ?>
                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $article->slug],
                            ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                        ?>
                    
                    <?php } ?>
                </div>
                <?php } ?>
                
            </div>
        <?php } ?>

        <?= $this->element('pagination') ?>
        
    </div>
</div>