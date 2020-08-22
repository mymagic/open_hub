<?php
/* @var $this IndividualController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Individuals',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Individual'), 'url' => array('/individual/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Individual'), 'url' => array('/individual/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Individuals'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
