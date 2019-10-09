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

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->Custom->siteName(); ?> - <?= $this->fetch('title') ?>
    </title>
    <meta name="description" content="<?= $this->fetch('description') ?>">
    <meta name="keywords" content="<?= $this->fetch('keywords') ?>">
    
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css("bootstrap.min.css") ?>
    <?= $this->Html->css('summernote-bs4.css') ?>
    <?= $this->Html->css('fontawesome/all.css') ?>
    <?= $this->Html->css('cms.css') ?>
    <?= $this->Html->css('user.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <style>
        <?php if($this->Custom->footerBottom()){ ?>
            .main-container {
              min-height: 95vh;
              
            }

        <?php } ?>
    </style>
</head>
<body>
    <div class="main-container">
    <?php          
        $menu_top_items = $this->Custom->topLinks();
        if($this->Custom->showSidebar()){
            $menu_side_items = $this->Custom->sideLinks();
        }
        $menu_bottom_items = $this->Custom->bottomLinks();
    ?>
    <div class="container<?php if($this->Custom->containerType()){echo '-fluid';} ?>">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <a class="navbar-brand" href="<?= $this->request->webroot ?>"><?= $this->Custom->siteName(); ?></a> 
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        
                        <?php 
                            foreach($menu_top_items as $item){
                        ?>
                        <li>
                            <a href="<?= $item->url ?>" <?= $item->new_tab ? 'target="_blank"':'' ?>><?= $item->name ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php
                            echo $this->Form->create(null, ['url'=>['controller' => 'articles', 'action' => 'search_query'], 'class'=>'form-inline my-2 my-lg-0']);     
                            echo $this->Form->control('search', ['label' => false, 'div' => false]);
                            echo $this->Form->button(__('Search'), ['class'=>'btn btn-info btn-sm']);
                            echo $this->Form->end();
                        ?>
                        <div class="dropdown-container dd-auth">
                            <a id="dropdownMenuButtonAuth" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="far fa-user"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAuth">
                                <?php if (!$this->Session->read('Auth.User')){ ?>
                                <?= $this->Html->link('Log In', ['controller' => 'users', 'action' => 'login'], ['class'=>'dropdown-item']) ?>
                                <?= $this->Html->link('Register', ['controller' => 'users', 'action' => 'register'], ['class'=>'dropdown-item']) ?>
                                <?php } else { ?>
                                <?= $this->Html->link('Backend', ['controller' => 'backend'], ['class'=>'dropdown-item']) ?>
                                <?= $this->Html->link('Log Out', ['controller' => 'users', 'action' => 'logout'], ['class'=>'dropdown-item']) ?>
                                <?php } ?>
                            </div> 
                        </div>
                  </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container<?php if($this->Custom->containerType()){echo '-fluid';} ?> clearfix">
        <div class="row">
            <div class="col-12 text-center">
                <?= $this->Flash->render() ?>
            </div>
        </div>
        <?php if($this->Custom->showSidebar()){ ?>
        <div class="row">
            <div class="col-<?php if($this->Custom->containerType()){echo '2';} else {echo '3';} ?> sidebar">                
                <ul>
                    <?php 
                        foreach($menu_side_items as $item){
                    ?>
                    <li>
                        <a href="<?= $item->url ?>" <?= $item->new_tab ? 'target="_blank"':'' ?>><?= $item->name ?></a>
                    </li>
                    <?php } ?>
                </ul>
                
                    <?php 
                    if($this->Custom->recentPosts()){ ?>
                    <span>Recent posts</span>
                    <ul>
                    <?php foreach($this->Custom->recentPosts() as $item){ 
                            if($item->_matchingData['Categories'] != null && $item->_matchingData['Categories']->title != null){
                                $category = $item->_matchingData['Categories']->title;
                            } else {
                                $category = 'view';
                            }
                        

                    ?>
                
                    <li>
                        <?= $this->Html->link($item->title, ['controller'=>'articles', 'action' => $category, $item->slug]) ?>
                    </li>
                
                    <?php } ?>
                    </ul>
                    <?php    }   ?>
                
                
                    <?php 
                    if($this->Custom->recentComments()){ ?>
                    <span>Recent comments</span>
                    <ul>       
                    <?php    foreach($this->Custom->recentComments() as $item){
                            if($item->article->category != null && $item->article->category->title != null){
                                $category = $item->article->category->title;
                            } else {
                                $category = 'view';
                            }
                    ?>
                
                    <li>
                        <strong><?= $item->user->username ?></strong>
                        <br>
                            <?= substr($item->body, 0, 20) ?>                             
                        
                        <br> on 
                            <?= $this->Html->link($item->article->title, ['controller'=>'articles', 'action' => $category, $item->article->slug]) ?>
                        
                    </li>
                
                    <?php } ?>
                    </ul>
                    <?php   }   ?>
               
                
                   <?php 
                   if($this->Custom->tagCloud()){ ?>
                    <div>
                        <span>Tags</span><br>
                    <?php foreach($this->Custom->tagCloud() as $tag){ 
                            $size = 10;
                            if($tag->amount <= 10){
                                $size += $tag->amount;
                            } else {
                                $size = 20;
                            }
                    ?>
                        <span style="font-size: <?= $size ?>px"><?= $this->Html->link($tag->title, ['controller'=>'articles', 'action' => 'tagged', $tag->title]) ?></span>                            
                    
                    <?php } ?>
                    </div>
                    <?php   }   ?>
                
                <div>
                    <?= $this->Custom->customWidget(); ?>
                </div>
            </div>
            <div class="col-<?php if($this->Custom->containerType()){echo '10';} else {echo '9';} ?>">  
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <?php } else { ?>
            <?= $this->fetch('content') ?>
        <?php } ?>
            
    </div>
    </div>
    <footer>
        <div class="container<?php if($this->Custom->containerType()){echo '-fluid';} ?>">
            <div class="row">
                <div class="col-12 text-center">
                    <?= $this->Custom->footerText() ?>
                </div>
                <div class="col-12">
                    <?php 
                        foreach($menu_bottom_items as $item){
                    ?>                
                    <a href="<?= $item->url ?>" <?= $item->new_tab ? 'target="_blank"':'' ?>><?= $item->name ?></a>
                    
                    <?php } ?>
                </div>
            </div>
        </div>
        <?= $this->Html->script("jquery.min.js") ?> 
        <?= $this->Html->script("Popper.js") ?> 
        <?= $this->Html->script("bootstrap.min.js") ?> 
        <?= $this->Html->script("summernote-bs4.min.js") ?> 
        <?= $this->Html->script("clipboard.min.js") ?> 

        <script>
            $(document).ready(function(){
                globals = {};
                globals.base_url = <?= $this->request->webroot ?>;
                globals.csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            });
        </script>

        <?= $this->Html->script("cms.js") ?> 
        <?= $this->Html->script("user.js") ?>    
    </footer>
</body>
</html>
