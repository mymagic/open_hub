<?php if (!empty($actions['revenue'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['revenue'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action['url'] ?>" title="<?php echo $action['title'] ?>"><?php echo $action['label'] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>

<div class="viewCard col-sm-6 item-flex collectible" data-collection-table_name="individual" data-collection-ref_id="<?php echo $data->id; ?>">
    <div class="media margin-md">

    <div class="media-left">
        <a href="<?php echo $this->createUrl('/individual/view', array('id' => $data->id)); ?>">
            <?php echo Html::activeThumb($data, 'image_photo', array('class' => 'media-object', 'lightbox' => false)); ?>
        </a>
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/individual/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->full_name; ?>
            <small><span class="text-muted">
                <?php if (!empty($data->gender)): ?>(<?php echo $data->formatEnumGender($data->gender); ?>) <?php endif; ?>
            </span>
            <?php echo Html::renderBoolean($data->is_active); ?>
            </small>
        </h4></a>
        <?php // if (Yii::app()->user->isSuperAdmin || Yii::app()->user->isSensitiveDataAdmin):?>
        <?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'adminSensitiveData']]) || Yii::app()->user->getState('accessSensitiveData')): ?>
            <?php if (!empty($data->ic_number)): ?><?php echo Html::faIcon('fa fa-id-card'); ?> <?php echo $data->ic_number; ?><?php endif; ?>
            <?php if (!empty($data->mobile_number)): ?>&nbsp;<?php echo Html::faIcon('fa fa-phone'); ?> <?php echo $data->mobile_number; ?><?php endif; ?>
        <?php endif; ?>
        </p>
        <div class="margin-bottom-md">
        Companies <?php foreach ($data->organizations as $organization): ?>
                <span class="label label-white"><a href="<?php echo $this->createUrl('/organization/view', array('id' => $organization->id)); ?>"><?php echo YsUtil::truncate($organization->title, 25); ?></a></span>
            <?php endforeach; ?>
        </div>
        <div>
        <?php foreach ($data->tags as $tag): ?>
            <span class="badge badge-info"><?php echo $tag->name; ?></span>
        <?php endforeach; ?>
        </div>
        <div>
            <a class="btn btn-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('fullName' => "'{$data->full_name}'")); ?>">View Journey</a>
        </div>
    </div>
    </div>
</div>


