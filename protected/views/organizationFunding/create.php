<?php
/* @var $this OrganizationFundingController */
/* @var $model OrganizationFunding */

$this->breadcrumbs = array(
	'Organization Fundings' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage OrganizationFunding'), 'url' => array('organizationFunding/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Organization Funding'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>