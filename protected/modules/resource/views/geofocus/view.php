<?php
/* @var $this ResourceGeofocusController */
/* @var $model ResourceGeofocus */

$this->breadcrumbs = array(
	'Resource Geofocuses' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ResourceGeofocus'), 'url' => array('//resource/geofocus/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create ResourceGeofocus'), 'url' => array('//resource/geofocus/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update ResourceGeofocus'), 'url' => array('//resource/geofocus/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete ResourceGeofocus'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>

<h1><?php echo Yii::t('backend', 'View Resource Geofocus'); ?></h1>

<div class="well text-right">
	<?php if ($model->is_active): ?>
	<a class="btn btn-danger" href="<?php echo $this->createUrl('deactivate', array('id' => $model->id)) ?>"><?php echo Html::faIcon('fa fa-trash') ?> <?php echo Yii::t('backend', 'Deactivate') ?></a>
	<?php else: ?>
	<a class="btn btn-warning" href="<?php echo $this->createUrl('activate', array('id' => $model->id)) ?>"><?php echo Html::faIcon('fa fa-recycle') ?> <?php echo Yii::t('backend', 'Activate') ?></a>
	<?php endif; ?>
</div>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'slug',
		//'title',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>




<ul class="nav nav-tabs">

    <?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>
    <?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>
    <?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>
</ul>
<div class="tab-content">

    <!-- English -->
    <?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
    <div class="tab-pane active" id="pane-en">

    <?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_en',
	),
)); ?>

    </div>
    <?php endif; ?>
    <!-- /English -->


    <!-- Bahasa -->
    <?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
    <div class="tab-pane " id="pane-ms">

    <?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_ms',
	),
)); ?>

    </div>
    <?php endif; ?>
    <!-- /Bahasa -->


    <!-- 中文 -->
    <?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
    <div class="tab-pane " id="pane-zh">

    <?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		),
)); ?>

    </div>
    <?php endif; ?>
    <!-- /中文 -->


</div>


</div>