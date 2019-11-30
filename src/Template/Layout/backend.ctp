<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->Custom->siteName(); ?> - Admin
    </title>
    
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css("bootstrap.min.css") ?>
    <?= $this->Html->css('summernote-bs4.css') ?>
    <?= $this->Html->css('fontawesome/all.css') ?>
    <?= $this->Html->css('cms.css') ?>
    
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
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">                 
                  <?= $this->Html->link('Admin', ['controller' => 'backend'], ['class'=>'navbar-brand']) ?> 
                  <div class="dropdown-container dd-auth ml-auto" style="position: relative !important;">
                        <a id="dropdownMenuButtonAuth" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="far fa-user"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAuth" style="margin-left: -130px;">
                            <?php if (!$this->Session->read('Auth.User')){ ?>
                            <?= $this->Html->link('Log In', ['controller' => 'users', 'action' => 'login'], ['class'=>'dropdown-item']) ?>
                            <?= $this->Html->link('Register', ['controller' => 'users', 'action' => 'register'], ['class'=>'dropdown-item']) ?>
                            <?php } else { ?>
                            <?= $this->Html->link('Backend', ['controller' => 'backend'], ['class'=>'dropdown-item']) ?>
                            <?= $this->Html->link('Log Out', ['controller' => 'users', 'action' => 'logout'], ['class'=>'dropdown-item']) ?>
                            <?php } ?>
                        </div> 
                    </div>                 
                </nav>

            </div>
        </div>
    </div>
    
    <div class="container-fluid clearfix">
        <div class="row">
            <div class="col-12 text-center">
                <?= $this->Flash->render() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-3 sidebar mt-3">                
                <ul>
                    <li><?= $this->Html->link('Manage Articles', ['controller'=>'articles', 'action' => 'all']); ?></li>
                    <li><?= $this->Html->link('Manage Pages', ['controller'=>'pages', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Manage Categories', ['controller'=>'categories', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Manage Tags', ['controller'=>'tags', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Manage Comments', ['controller'=>'comments', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Manage Users', ['controller'=>'users', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Files', ['controller'=>'files', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Custom CSS', ['controller'=>'options', 'action' => 'customCss']); ?></li>
                    <li><?= $this->Html->link('Custom JS', ['controller'=>'options', 'action' => 'customJs']); ?></li>
                    <li><?= $this->Html->link('Sliders', ['controller'=>'sliders', 'action' => 'index']); ?></li>
                    <li><?= $this->Html->link('Menus', ['controller'=>'menus', 'action' => 'index']); ?></li>
                </ul>
                
            </div>
            <div class="col-9 mt-3">  
                <?= $this->fetch('content') ?>
            </div>
        </div>
        
            
    </div>
    </div>
    <footer>
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-12 text-center">
                    © Garbage_kinG 2019
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
                globals.base_url = '<?= $this->request->webroot ?>';
                globals.csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            });
        </script>

        <?= $this->Html->script("cms.js") ?> 
    </footer>     
    
</body>
</html>
