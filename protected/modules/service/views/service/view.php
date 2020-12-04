<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs = array(
	'Services' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Service'), 'url' => array('/service/service/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Service'), 'url' => array('/service/service/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Service'), 'url' => array('/service/service/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update') && $model->is_active
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Service'); ?></h1>

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
		'title',
		array('name' => 'text_oneliner', 'type' => 'raw', 'value' => nl2br($model->text_oneliner)),
		array('name' => 'is_bookmarkable', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_bookmarkable)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>