<?php
/* @var $this Form2IntakeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Form2 Intakes',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Form2Intake'), 'url' => array('/f7/form2Intake/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Form2Intake'), 'url' => array('/f7/form2Intake/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Form2 Intakes'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
