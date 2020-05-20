<?php
/* @var $this EventOwnerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Owners',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Owner'), 'url' => array('/eventOwner/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Owner'), 'url' => array('/eventOwner/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Event Owners'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
