<?php
/* @var $this SubmissionController */
/* @var $model FormSubmission */

$this->breadcrumbs = array(
	'Submissions' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Form'), 'url' => array('/f7/submission/admin'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Submission'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>