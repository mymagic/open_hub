<?php if (!empty($actions['organization'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['organization'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']; ?>" href="<?php echo $action['url']; ?>" title="<?php echo $action['title']; ?>"><?php echo $action['label']; ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
        <h3><?php echo Yii::t('backend', 'Organizations Involved') ?></h3>
        <?php if (!empty($model->individualOrganizations)): ?>
        <?php foreach ($model->individualOrganizations as $individualOrganization):?>
            <?php if (!$individualOrganization->individual->is_active) {
	continue;
} ?>
            <li><a href="<?php echo $this->createUrl('organization/view', array('id' => $individualOrganization->organization->id)); ?>" target="_blank"><strong><?php echo $individualOrganization->organization->title; ?></strong> (<?php echo $individualOrganization->as_role_code; ?>) <?php echo Html::renderBoolean($individualOrganization->organization->is_active); ?></a>
            </li>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

