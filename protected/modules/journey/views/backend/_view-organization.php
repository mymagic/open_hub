<div class="viewCard col-sm-6 item-flex collectible" data-collection-table_name="organization" data-collection-ref_id="<?php echo $data->id; ?>">
    <div class="media margin-md">
    
    <div class="media-left">
        <a href="<?php echo $this->createUrl('/organization/view', array('id' => $data->id)); ?>">
            <?php echo Html::activeThumb($data, 'image_logo', array('class' => 'media-object', 'lightbox' => false)); ?>
        </a>
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/organization/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->title; ?>
            <small><span class="text-muted">
                <?php if (!empty($data->legal_name)): ?><?php echo $data->legal_name; ?><?php endif; ?> 
                <?php if (!empty($data->company_number)): ?>(<?php echo $data->company_number; ?>) <?php endif; ?>
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        <?php echo !empty($data->text_oneliner) ? $data->text_oneliner : $data->text_short_description; ?>
        <p>
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


