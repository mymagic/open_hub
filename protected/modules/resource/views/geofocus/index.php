<?php
/* @var $this ResourceGeofocusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Resource Geofocuses',
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
);
?>

<h1><?php echo Yii::t('backend', 'Resource Geofocuses'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
