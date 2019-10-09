<?= $this->element('slider') ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
  	<li class="breadcrumb-item"><a href="<?= $this->request->webroot ?>">Home</a></li>    
    <li class="breadcrumb-item active" aria-current="page"><?= h($page->title) ?></li>
  </ol>
</nav>
<?php 
$this->assign('title', $page->title); 
$this->assign('description', $page->description);
$this->assign('keywords', $page->keywords);
?>
<div><?= $page->body ?></div>
<?php
    echo $this->Form->create(null, ['url'=>['controller' => 'spages', 'action' => 'emailit']]);
    echo $this->Form->control('name', ['label' => 'Your Name', 'required' => 'required', 'class' => 'form-control']);
    echo $this->Form->control('email', ['type' => 'email', 'label' => 'Your Email', 'required' => 'required', 'class' => 'form-control']);
    echo $this->Form->control('message', ['type' => 'textarea', 'label' => 'Your Message', 'required' => 'required', 'class' => 'form-control']);
    echo $this->Form->button(__('Send'));
    echo $this->Form->end();
?>
<?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User')['role_id'] < 4){ ?>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $page->slug], ['class'=>'btn btn-sm btn-primary']) ?></p>

<?php } ?>