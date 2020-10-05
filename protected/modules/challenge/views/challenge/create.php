<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs = array(
	'Challenges' => array('index'),
	Yii::t('challenge', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('challenge', 'Manage Challenge'), 'url' => array('/challenge/challenge/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('challenge', 'Create Challenge'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>