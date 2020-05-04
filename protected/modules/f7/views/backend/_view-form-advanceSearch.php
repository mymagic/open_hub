<div class="viewCard col-sm-6 item-flex">
    <div class="media margin-md">
    
    <div class="media-left">
        <?php $intake = $data->getIntake(); ?>
        <?php if ($intake && !empty($intake->image_logo)): ?>
        <a href="<?php echo $this->createUrl('/f7/form/view', array('id' => $data->id)); ?>">
            <?php echo Html::activeThumb($intake, 'image_logo', array('class' => 'media-object', 'lightbox' => false)); ?>
        </a>
        <?php endif; ?>
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/f7/form/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php if (!empty($data->intakes[0])): ?><?php echo $data->intakes[0]->title; ?> \ <?php endif; ?><?php echo $data->title; ?>
            <small><span class="text-muted">
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        <p>From <b><?php echo $data->renderDateOpen() ?></b> to <b><?php echo $data->renderDateClose() ?></b>
        <?php echo YsUtil::truncate(($data->text_short_description)); ?>
        <div>
        </div>
    </div>
    </div>
</div>


