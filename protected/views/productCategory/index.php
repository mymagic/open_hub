<?php
/* @var $this ProductCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Product Categories',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ProductCategory'), 'url' => array('/productCategory/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create ProductCategory'), 'url' => array('/productCategory/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Product Categories'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
