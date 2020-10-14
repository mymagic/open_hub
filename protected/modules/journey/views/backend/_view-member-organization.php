
<div class="row">
    <div class="col col-xs-12"> 
        <h3><?php echo Yii::t('backend', 'Associated Organization Profiles') ?></h3>
        <p><?php echo Yii::t('backend', "Member '{name}' has access to the following organization profiles", array('{name}' => $member->user->profile->full_name))?></p>
    </div>
</div>
<div class="row">
    <?php $organizations = HubMember::getOrganizations($member); if (!empty($organizations)): ?>
    <?php foreach ($organizations as $organization):?>
        <?php if (!$organization->is_active) {
	continue;
} ?>

        <div class="col-md-4 col-sm-6 margin-top-md">
        <div class="">
            <div class="ibox-content text-center widget-head-color-box navy-bg p-lg">
                <h2><?php echo ysUtil::truncate($organization->title, 15) ?></h2>
                <div class="m-b-sm">
                    <?php echo Html::activeThumb($organization, 'image_logo', array('class' => 'img-circle')) ?>
                </div>

                <p class="font-bold"><?php echo ysUtil::truncate($organization->text_oneliner, 100) ?></p>

            </div>
            <div class="ibox-content border text-center gray-bg">
                <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo $this->createUrl('organization/view', array('id' => $organization->id)) ?>"><i class="fa fa-search"></i> View</a>
            </div>
        </div>
        </div>


    <?php endforeach; ?>
    <?php endif; ?>
</div>