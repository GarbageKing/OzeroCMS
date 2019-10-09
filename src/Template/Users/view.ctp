<h1><?= h($user->username) ?></h1>
<?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back to Users', ['action' => 'index'], ['escape' => false]) ?>

<h3><?= h($user->email) ?></h3>
<p><small>Created: <?= $user->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?></p>
<p><?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $user->id],
                        ['confirm' => 'Are you sure?'])
                    ?>
</p>