<?php
/* @var $this Resource2OrganizationFundingController */
/* @var $model Resource2OrganizationFunding */

$this->breadcrumbs = array(
	'Resource2 Organization Fundings' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Resource2 Organization Funding'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>