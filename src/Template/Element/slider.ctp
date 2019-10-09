<?php if($slider){ ?>

<?php if($slider->is_slider){ ?>
<div id="carouselSlider" class="carousel slide mb-0" data-ride="carousel">  
  <div class="carousel-inner">
    <?php $make_active = true; foreach($slider->slides as $slide){?>
    <div class="carousel-item <?php if($make_active){echo 'active'; $make_active = false;} ?>">
      <img class="d-block w-100" style="max-height: 300px;" src="<?= $this->request->webroot . 'webroot/uploads/' . $slide->file->file_name ?>">
      <div class="carousel-caption d-none d-md-block">
      <?= $slide->text; ?>
    </div>
    </div>
    <?php } ?>
  </div>
  <a class="carousel-control-prev" href="#carouselSlider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselSlider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php } else {  $slide = $slider->slides{0}; ?>
<div class="jumbotron jumbotron-fluid mb-0" style="background-image: url('<?= $this->request->webroot . 'webroot/uploads/' . $slide->file->file_name ?>');background-size: 100% 100%; height: 300px;">
  <div class="container">
    <?php echo $slide->text; ?>
  </div>
</div>
<?php } ?>

<?php } ?>