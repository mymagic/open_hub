<?php
/* @var $this EventGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Groups',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Group'), 'url' => array('/eventGroup/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Group'), 'url' => array('/eventGroup/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Event Groups'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
