<?php
/* @var $this ResourceCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Resource Categories',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ResourceCategory'), 'url' => array('//resource/category/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create ResourceCategory'), 'url' => array('//resource/category/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Resource Categories'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
