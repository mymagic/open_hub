<?php
/* @var $this ImpactController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Impacts',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Impact'), 'url' => array('/impact/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Impact'), 'url' => array('/impact/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Impacts'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
