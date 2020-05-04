<?php
/* @var $this RequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Requests',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Request'), 'url' => array('/request/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Request'), 'url' => array('/request/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Requests'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
