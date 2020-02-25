<?php
/* @var $this ResourceGeofocusController */
/* @var $model ResourceGeofocus */

$this->breadcrumbs = array(
	'Resource Geofocuses' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage ResourceGeofocus'), 'url' => array('//resource/geofocus/admin')),
	array('label' => Yii::t('app', 'Create ResourceGeofocus'), 'url' => array('//resource/geofocus/create')),
	array('label' => Yii::t('app', 'View ResourceGeofocus'), 'url' => array('//resource/geofocus/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Resource Geofocus'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>