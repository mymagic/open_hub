<?php
/* @var $this IntakeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Intakes',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Intake'), 'url' => array('/f7/intake/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Intake'), 'url' => array('/f7/intake/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Intakes'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
