<?php
/* @var $this SdgController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Sdgs',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Sdg'), 'url' => array('/sdg/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Sdg'), 'url' => array('/sdg/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Sdgs'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
