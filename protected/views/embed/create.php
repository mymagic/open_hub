<?php
/* @var $this EmbedController */
/* @var $model Embed */

$this->breadcrumbs = array(
	'Embeds' => array('index'),
	'Create',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Embed'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Embed'), 'url' => array('create'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Embed')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>