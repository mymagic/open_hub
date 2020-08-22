<?php
/* @var $this IndustryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Industries',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Industry'), 'url' => array('/industry/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Industry'), 'url' => array('/industry/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Industries'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
