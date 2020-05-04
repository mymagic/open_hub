<?php
/* @var $this SubmissionController */
/* @var $model FormSubmission */

$this->breadcrumbs = array(
	'Submissions' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Submission'), 'url' => array('/f7/submission/admin'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Submission'), 'url' => array('/f7/submission/create'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View Submission'), 'url' => array('/f7/submission/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Submission'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>