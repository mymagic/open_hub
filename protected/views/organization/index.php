<?php
/* @var $this OrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	Yii::t('app', 'Organizations'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Organizations'), 'url' => Yii::app()->createUrl('organization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'admin']])
	),
	array(
		'label' => Yii::t('app', 'Create Organization'), 'url' => Yii::app()->createUrl('organization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'create']])),
);
?>


<?php if ($realm === 'backend') {
	?>

<h1><?php echo Yii::t('backend', 'Organizations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<?php
} elseif ($realm === 'cpanel') {
	?>

	<section>
    <h2><?php echo Yii::t('app', 'My Organization List')?></h2>
    <?php if (empty($model)) : ?>
        <div class="px-8 py-6 nav-select shadow-panel">
            <div class="row md:flex md:items-center">
                <div class="col-md-8">
                    <h3><?php echo Yii::t('backend', 'Don’t have an organization yet')?>?</h3>
                    <p><?php echo Yii::t('app', 'If your organization is not exists in our system yet, please create an organization profile here')?></p>
                </div>
                <div class="col-md-4 flex md:justify-end">
                    <a class="btn btn-outline btn-default btn-lg" style="color: #333; line-height: 1.3333333;" href="<?php echo $this->createUrl('/organization/create/', array('realm' => $realm)) ?>"><?php echo Yii::t('app', 'Create Organization')?> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="list_content my-3">
        <?php foreach ($model as $data) : ?>
            <div class="row">
                <a href="<?php echo $this->createUrl('/organization/view/', array('id' => $data['id'], 'realm' => $realm)); ?>">
                    <div class="col-sm-2 col-md-1 col-lg-1">
                        <img src="<?php echo $data['imageLogoThumbUrl'] ?>" class="img-responsive" />
                    </div>
                    <div class="col-sm-5 col-md-7 col-lg-7">
                        <h3><?php echo $data['title'] ?></h3>
                        <p class="text-muted"><?php echo $data['text_oneliner'] ?></p>
                        <!-- <?php foreach ($data['industries'] as $industry) : ?>
                            <span class="label label-default"><?php echo $industry['title'] ?></span>
                        <?php endforeach; ?>
                        <?php foreach ($data['sdgs'] as $sdg) : ?>
                            <span class="label label-default"><?php echo $sdg['title'] ?></span>
                        <?php endforeach; ?> -->
                    </div>
                    <div class="col-sm-5 col-md-4 col-lg-4">
                        <div class="col-xs-6 text-center"><small><?php echo Yii::t('app', 'Incorporated')?></small><br /><strong><?php echo Html::encodeDisplay($data['year_founded']) ?></strong></div>
                    </div>
                    <div class="col-xs-12">

                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<?php
} ?>
