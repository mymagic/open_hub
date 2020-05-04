<?php
/* @var $this IndustryController */
/* @var $model Industry */

$this->breadcrumbs = array(
	'Industries' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Industry'), 'url' => array('/industry/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Industry'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>