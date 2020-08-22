<?php
/* @var $this OrganizationStatusController */
/* @var $model OrganizationStatus */

$this->breadcrumbs = array(
	'Organization Statuses' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage OrganizationStatus'), 'url' => array('/organizationStatus/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Organization Status'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>