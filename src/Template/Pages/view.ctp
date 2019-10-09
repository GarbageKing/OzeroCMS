<?= $this->element('slider') ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	<li class="breadcrumb-item"><a href="<?= $this->request->webroot ?>">Home</a></li>    
    <li class="breadcrumb-item active" aria-current="page"><?= h($page->title) ?></li>
  </ol>
</nav>

<?php //debug($slider);
$this->assign('title', $page->title); 
$this->assign('description', $page->description);
$this->assign('keywords', $page->keywords);
?>
<p><?= $page->body ?></p>
<?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){ ?>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $page->slug], ['class'=>'btn btn-sm btn-primary']) ?></p>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $page->slug],
                        ['class'=>'btn btn-sm btn-danger', 'confirm' => 'Are you sure?'])
                    ?>
</p>
<?php } ?>