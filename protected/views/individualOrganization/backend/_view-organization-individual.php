<?php if (!empty($actions['individual'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach ($actions['individual'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action['url'] ?>" title="<?php echo $action['title'] ?>"><?php echo $action['label'] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-xs-12"> 
        <h3><?php echo Yii::t('backend', 'Individual Involved') ?></h3>
    </div>
</div>
<div class="row">
    <?php if (!empty($model->individualOrganizations)): ?>
    <?php foreach ($model->individualOrganizations as $individualOrganization):?>
        <?php if (!$individualOrganization->individual->is_active) {
	continue;
} ?>

        <div class="col-md-4 col-sm-6 margin-top-md">
        <div class="">
            <div class="ibox-content text-center widget-head-color-box navy-bg p-lg">
                <h2><?php echo ysUtil::truncate($individualOrganization->individual->full_name, 18) ?></h2>
                <div class="m-b-sm">
                    <?php echo Html::activeThumb($individualOrganization->individual, 'image_photo', array('class' => 'img-circle')) ?>
                </div>

                <p class="font-bold"><?php echo ucwords($individualOrganization->as_role_code) ?></p>
            </div>
            <div class="ibox-content border text-center gray-bg">
                <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo $this->createUrl('individual/view', array('id' => $individualOrganization->individual->id)) ?>"><i class="fa fa-search"></i> View</a>
            </div>
        </div>
        </div>


    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php $result = HubIndividual::getRelatedEmailIndividual($model); ?>
<?php if (!empty($result)): ?>
<div class="row">
    <div class="col col-xs-12 margin-top-3x"> 
        <p><span class="label label-warning"><?php echo Yii::t('backend', 'Suggestion') ?></span> <?php echo Yii::t('backend', 'the following individuals may be related base on associated emails') ?></p>
    </div>
</div>
<div class="row">
    
    <?php foreach ($result as $email => $individuals): ?>
    
    <div class="col-md-4 col-sm-6 margin-top-md">
    <div class="border">
        <div class="ibox-content text-center gray-bg">
            <?php echo $email ?>
        </div>
        <?php foreach ($individuals as $individual): ?>
        <div class="ibox-content text-center gray-bg">
            <h3 class="text-muted"><?php echo $individual->full_name ?></h3>
            <div class="m-b-sm">
                <?php echo Html::activeThumb($individual, 'image_photo', array('class' => 'img-circle')) ?>
            </div>

            <div class="text-center gray-bg">
                <a class="btn btn-xs btn-white" href="<?php echo $this->createUrl('/individual/view', array('id' => $individual->id)) ?>" target="_blank"><i class="fa fa-search"></i> View </a>
                <a class="btn btn-xs btn-primary" target="_blank" href="<?php echo $this->createUrl('/individualOrganization/create', array('individualId' => $individual->id, 'organizationCode' => $model->code)) ?>"><i class="fa fa-link"></i> Link</a>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    </div>

    <?php endforeach; ?>
</div>
<?php endif; ?>


