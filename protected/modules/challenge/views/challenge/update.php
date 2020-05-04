<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs = array(
	'Challenges' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Challenge'), 'url' => array('/challenge/challenge/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Challenge'), 'url' => array('/challenge/challenge/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View Challenge'), 'url' => array('/challenge/challenge/view', 'id' => $model->id), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
	array(
		'label' => Yii::t('app', 'Delete Challenge'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Challenge'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>