<?php
/* @var $this StateController */
/* @var $model State */

$this->breadcrumbs = array(
	'States' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage State'), 'url' => array('/state/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create State'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>