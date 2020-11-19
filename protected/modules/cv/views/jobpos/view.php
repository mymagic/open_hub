<?php
/* @var $this CvJobposController */
/* @var $model CvJobpos */

$this->breadcrumbs = array(
	'Jobpos' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos'), 'url' => array('/cv/jobpos/admin')),
	array('label' => Yii::t('app', 'Create Jobpos'), 'url' => array('/cv/jobpos/create')),
	array('label' => Yii::t('app', 'Update Jobpos'), 'url' => array('/cv/jobpos/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Jobpos'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Jobpos'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'cv_jobpos_group_id', 'value' => $model->cvJobposGroup->title),
		'title',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>