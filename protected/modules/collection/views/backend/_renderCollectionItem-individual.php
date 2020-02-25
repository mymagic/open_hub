<div class="thumbnail">
    <a href="<?php echo $this->createUrl('/individual/view', array('id' => $model->id)) ?>" target="_blank">
    <img src="<?php echo $model->getImagePhotoThumbUrl(); ?>" class="img-responsive" />
    <div class="caption"><?php echo $model->full_name; ?></div>
    </a>
</div>