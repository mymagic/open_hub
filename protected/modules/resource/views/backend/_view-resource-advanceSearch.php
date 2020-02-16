<div class="viewCard col-sm-6 item-flex collectible" data-collection-table_name="resource" data-collection-ref_id="<?php echo $data->id; ?>">
    <div class="media margin-md">
    
    <div class="media-left">
        <a href="<?php echo $this->createUrl('/resource/resource/view', array('id' => $data->id)); ?>">
            <?php echo Html::activeThumb($data, 'image_logo', array('class' => 'media-object', 'lightbox' => false)); ?>
        </a>
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/resource/resource/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->title; ?>
            <small><span class="text-muted">
                <?php echo $data->renderTypeFor(); ?>
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        <?php echo YsUtil::truncate(strip_tags($data->html_content)); ?>
        <div class="margin-bottom-md">
        By <?php foreach ($data->organizations as $organization): ?>
                <span class="label label-white"><a href="<?php echo $this->createUrl('/organization/view', array('id' => $organization->id)); ?>"><?php echo YsUtil::truncate($organization->title, 25); ?></a></span>
            <?php endforeach; ?>
        </div>
        <p>
        <?php if (!empty($data->url_website)): ?><?php echo Html::faIcon('fa fa-globe'); ?> <a href="<?php echo $data->url_website; ?>" target="_blank"><?php echo $data->url_website; ?></a><?php endif; ?>       
        </p>
        
        <div>
        <?php foreach ($data->tags as $tag): ?>
            <span class="badge badge-info"><?php echo $tag->name; ?></span>
        <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>


