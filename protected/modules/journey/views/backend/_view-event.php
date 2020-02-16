<div class="viewCard col-sm-12 item-flex">
    <div class="media margin-md">
    
    <div class="media-left">
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/event/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->title; ?>
            <small><span class="text-muted">
                <?php if (!empty($data->eventGroup)): ?>(<?php echo $data->eventGroup->title; ?>) <?php endif; ?>
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        From <b><?php echo $data->renderDateStarted(); ?></b> to <b><?php echo $data->renderDateEnded(); ?></b><br />
        <p>
        <?php if (!empty($data->at)): ?><?php echo Html::faIcon('fa fa-map-marker'); ?> <?php echo $data->at; ?><br /><?php endif; ?>
        <?php if (!empty($data->url_website)): ?><?php echo Html::faIcon('fa fa-globe'); ?> <a href="<?php echo $data->url_website; ?>" target="_blank"><?php echo $data->url_website; ?></a><?php endif; ?>
        <?php if (!empty($data->email_contact)): ?>&nbsp;<?php echo Html::faIcon('fa fa-envelope'); ?> <?php echo $data->email_contact; ?><?php endif; ?>
        </p>
        <div>
        <?php foreach ($data->tags as $tag): ?>
            <span class="badge badge-info"><?php echo $tag->name; ?></span>
        <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>


