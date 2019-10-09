<div class="row mt-3">
    <div class="col-6">
        <h1>Files</h1>
    </div>    
    <div class="col-6 text-right">
        <div class="row">
            <div class="col-sm-8 text-right">
                <select id="sort_articles" class="form-control">
                    <option value="desc" selected>Newer first</option>
                    <option value="asc">Older first</option>
                </select>
            </div>            
            <div class="col-sm-4">
                <?= $this->Html->link('Add New', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
          

            <?php foreach ($files as $file){  ?>

            <div class="col-6 col-md-3 text-center mb-3 filestorage-item">
                                 
                    <a id="dropdownMenuButton<?= $file->id ?>" class="dropdown-toggle filestorage-dd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">

                    <div class="contain-preview">
                    <?php if($file->preview != null && $file->preview != '') { ?> 
                        <img src="<?= $this->request->webroot . 'webroot/uploads/' . $file->preview ?>" title="<?= $file->title ?>">                        
                    <?php } else { ?>
                        <i class="fas fa-file fa-7x"></i>                        
                    <?php } ?>
                    </div>

                    <div class="caption center-block bg-info"><?= mb_substr($file->file_name, 0, 20) ?></div>
                    

                    </a>  

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $file->id ?>">
                        <a class="dropdown-item copy-stuff" href="#" data-clipboard-text="<?= $this->request->webroot . 'webroot/uploads/' . $file->file_name ?>">Copy URL</a>
                        <a class="dropdown-item" href="<?= $this->request->webroot . 'files/edit/' . $file->id ?>">View / Edit description</a>                        
                        <?= $this->Form->postLink(
                            'Delete',
                            ['action' => 'delete', $file->id],
                            ['confirm' => 'Are you sure?', 'class'=>'dropdown-item'])
                        ?>
                      </div>                                    
                              
            </div>

            <?php } ?>
       
    <div class="col-12">
         <?= $this->element('pagination') ?>
    </div>
</div>