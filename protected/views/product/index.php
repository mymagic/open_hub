<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Products',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Product'), 'url' => array('/product/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Product'), 'url' => array('/product/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Products'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
