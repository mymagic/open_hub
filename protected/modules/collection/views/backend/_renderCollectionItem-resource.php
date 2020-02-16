<div class="thumbnail">
    <a href="<?php echo $this->createUrl('/resource/view', array('id'=>$model->id)) ?>" target="_blank">
    <img src="<?php echo $model->getImageLogoThumbUrl(); ?>" class="img-responsive" />
    <div class="caption"><?php echo $model->title; ?></div>
    </a>
</div>