
<div class="row">
    <div class="col col-xs-12"> 
        <h3><?php echo Yii::t('backend', 'Associated Individual Profiles') ?></h3>
        <p><?php echo Yii::t('backend', "Member '{name}' email '{email}' is associated to the following individual profiles", array('{name}' => $member->user->profile->full_name, '{email}' => $member->user->username))?></p>
    </div>
</div>
<div class="row container-flex">
    <?php $individuals = HubMember::getIndividuals($member); if (!empty($individuals)): ?>
    <?php foreach ($individuals as $individual):?>
        <?php if (!$individual->is_active) {
	continue;
} ?>

        <div class="col-md-4 col-sm-6 margin-top-md">
        <div class="">
            <div class="ibox-content text-center widget-head-color-box navy-bg p-lg">
                <h2><?php echo ysUtil::truncate($individual->full_name, 15) ?></h2>
                <div class="m-b-sm">
                    <?php echo Html::activeThumb($individual, 'image_photo', array('class' => 'img-circle')) ?>
                </div>

                <p class="font-bold"><?php echo ucwords($individual->country->printable_name) ?><?php if (!empty($individual->gender)): ?>, <?php echo ucwords($individual->gender) ?><?php endif; ?></p>

            </div>
            <div class="ibox-content border text-center gray-bg">
                <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo $this->createUrl('individual/view', array('id' => $individual->id)) ?>"><i class="fa fa-search"></i> View</a>
            </div>
        </div>
        </div>


    <?php endforeach; ?>
    <?php endif; ?>
</div>