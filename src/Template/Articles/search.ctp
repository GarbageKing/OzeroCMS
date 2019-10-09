<?= $this->element('slider') ?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->request->webroot ?>">Home</a></li>
            <li class="breadcrumb-item"><?= $this->Html->link('Articles', ['controller' => 'articles', 'action' => 'index']) ?></li>   
            <li class="breadcrumb-item active" aria-current="page">Results</li>     
          </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-9">        
            <h1> Search results for 
        <?= '"' . $search . '"' ?></h1>
    </div> 

    <div class="col-sm-3 text-right">
        <select id="sort_articles" class="form-control">
            <option value="desc" selected>Newer first</option>
            <option value="asc">Older first</option>
        </select>    
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <?php foreach ($articles as $article): 

            if($article->_matchingData['Categories']->title != null){
                $category = $article->_matchingData['Categories']->title;
            } else {
                $category = 'view';
            }
        ?>
            <article>
                
                <h4><?= $this->Html->link(
                    $article->title,
                    ['controller' => 'Articles', 'action' => $category, $article->slug]
                ) ?></h4>
                <span><?= $article->created->format('d-m-Y h:i:s') ?></span>
            </article>
        <?php endforeach; ?>

                <?= $this->element('pagination') ?>
    </div>
</div>