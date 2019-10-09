<?= $this->element('slider') ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	<li class="breadcrumb-item"><a href="<?= $this->request->webroot ?>">Home</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Articles', ['controller' => 'articles', 'action' => 'index']) ?></li>
    <?php if($article->category != null) {
    		if($article->category->parent_category != null) {
    ?>
    <li class="breadcrumb-item"><?= $this->Html->link($article->category->parent_category->title, ['controller' => 'articles', 'action' => 'category', $article->category->parent_category->title]) ?></li>

    	<?php } ?>

    <li class="breadcrumb-item"><?= $this->Html->link($article->category->title, ['controller' => 'articles', 'action' => 'category', $article->category->title]) ?></li>
    <?php } ?>
    <li class="breadcrumb-item active" aria-current="page"><?= h($article->title) ?></li>
  </ol>
</nav>

<?php 
$this->assign('title', $article->title);
$this->assign('description', $article->description);
$this->assign('keywords', $article->keywords);
 ?>
<p><?= $article->body ?></p>
<p><b>Tags:</b> <?= $article->tag_links ?></p>
<p><small>Created: <?= $article->created->format('d-m-Y H:i:s') ?></small></p>
<?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){ ?>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug], ['class' => 'btn btn-sm btn-primary']) ?></p>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $article->slug],
                        ['class' => 'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
<?php } ?>

<div class="row article-comments">
  <div class="col-12 mt-3">
    <h4>Comments:</h4>
  </div>
  <div class="col-8">
    <?php foreach($article->comments as $com){ ?>

      <div class="card">
          <div class="card-body">
              <div class="row">              
                  <div class="col-12">   
                      <h5 class="mt-0"><?= $com->user->username; ?> on <?= $com->created->format('d-m-Y H:i:s') ?>:</h5>   

                      <?php if($com->parent_comment != null) { ?>
                      <div class="card card-inner border-left">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12">
                            <strong><?= $com->parent_comment->user->username; ?> on <?= $com->parent_comment->created->format('d-m-Y H:i:s') ?>:</strong><br>
                            <?= $com->parent_comment->body ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php } ?>    

                      <p class="mt-1"><?= $com->body; ?></p>
                      <p class="text-right">
                          <button class="answer-comment-id btn btn-success btn-sm" data-id="<?= $com->id; ?>" data-user="<?= $com->user->username; ?>">Reply</button>
                     </p>
                  </div>
              </div>
                
          </div>

          <?php if ($this->Session->read('Auth.User')){ ?>
          <div class="col-12 text-left">
            <?= $this->Html->link('Edit', ['controller' => 'comments', 'action' => 'edit', $com->id], ['class' => 'btn btn-sm btn-primary']) ?> |
            <?= $this->Form->postLink(
                              'Delete',
                              ['controller' => 'comments', 'action' => 'delete', $com->id],
                              ['class' => 'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                          ?>
          </div>
          <?php } ?>
      </div>

    <?php } ?>
   
    <br>
    <?php
       	echo $this->Form->create($comment, ['url' => ['controller' => 'comments', 'action' => 'add']]); 
       	echo $this->Form->hidden('answers');    	
       	echo $this->Form->control('body', ['id' => 'comment_body', 'label'=>'Write a Comment', 'class' => 'form-control']);    
        echo $this->Form->button(__('Save'), ['class'=>'btn btn-success mt-2']);
        echo $this->Form->end();
    ?>

  </div>
</div>