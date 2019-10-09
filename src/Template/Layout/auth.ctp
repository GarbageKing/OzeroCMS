<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->Custom->siteName(); ?>
    </title>
    
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css("bootstrap.min.css") ?>    
    <?= $this->Html->css('fontawesome/all.css') ?>
        
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
                    <a href="<?= $this->request->webroot ?>" class="navbar-brand"><?= $this->Custom->siteName() ?></a>       
                    <div class="dropdown-container dd-auth ml-auto" style="position: relative !important;">
                        <a id="dropdownMenuButtonAuth" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="far fa-user"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAuth" style="margin-left: -130px;">
                            
                            <?= $this->Html->link('Log In', ['controller' => 'users', 'action' => 'login'], ['class'=>'dropdown-item']) ?>
                            <?= $this->Html->link('Register', ['controller' => 'users', 'action' => 'register'], ['class'=>'dropdown-item']) ?>
                            
                        </div> 
                    </div>           
                </nav>

            </div>
        </div>
    </div>

    
    <div class="container clearfix">
        <div class="row">
            <div class="col-12 text-center">
                <?= $this->Flash->render() ?>
            </div>
        </div>
        <div class="row">            
            <div class="col-md-6 offset-md-3 mt-3">  
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
    </footer>     
    
</body>
</html>
