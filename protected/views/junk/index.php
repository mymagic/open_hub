<?php
/* @var $this JunkController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Junks',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Junk'), 'url' => array('/junk/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Junk'), 'url' => array('/junk/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Junks'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
