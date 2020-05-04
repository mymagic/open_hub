<?php
/* @var $this FormController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Forms',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Form'), 'url' => array('/f7/from/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Form'), 'url' => array('/f7/form/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Forms'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
