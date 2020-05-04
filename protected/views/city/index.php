<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Cities',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage City'), 'url' => array('/city/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create City'), 'url' => array('/city/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Cities'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
