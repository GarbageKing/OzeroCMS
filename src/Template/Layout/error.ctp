<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css("bootstrap.min.css") ?>    
    <?= $this->Html->css('fontawesome/all.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1><?= __('Error') ?></h1>

                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>

                <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Back', 'javascript:history.back()', ['escape'=>false]) ?>
            </div>
        </div>
    </div>

</body>
</html>
