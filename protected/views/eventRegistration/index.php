<?php
/* @var $this EventRegistrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Registrations',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Registration'), 'url' => array('/eventRegistration/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Registration'), 'url' => array('/eventRegistration/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Event Registrations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
