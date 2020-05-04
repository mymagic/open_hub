<?php
/* @var $this JunkController */
/* @var $model Junk */

$this->breadcrumbs = array(
	'Junks' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Junk'), 'url' => array('/junk/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Junk'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>