<div class="viewCard col-sm-6 item-flex">
    <div class="media margin-md">
    
    <div class="media-left">
        <a href="<?php echo $this->createUrl('/interest/xxx/view', array('id' => $data->id)); ?>">
            <?php echo Html::activeThumb($data, 'image_logo', array('class' => 'media-object', 'lightbox' => false)); ?>
        </a>
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/interest/xxx/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->title; ?>
            <small><span class="text-muted">
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        <?php echo YsUtil::truncate(($data->text_oneliner)); ?>
        <div>
        <?php foreach ($data->tags as $tag): ?>
            <span class="badge badge-info"><?php echo $tag->name; ?></span>
        <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>


