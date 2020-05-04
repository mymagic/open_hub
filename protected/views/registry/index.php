<?php
/* @var $this RegistryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Registries',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Registry'), 'url' => array('/registry/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Registry'), 'url' => array('/registry/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Registries'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
