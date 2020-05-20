<?php
/* @var $this EventOrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Event Organizations',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Organization'), 'url' => array('/eventOrganization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Organization'), 'url' => array('/eventOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Event Organizations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
