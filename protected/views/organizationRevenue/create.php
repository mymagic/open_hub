<?php
/* @var $this OrganizationRevenueController */
/* @var $model OrganizationRevenue */

$this->breadcrumbs = array(
	'Organization Revenues' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage OrganizationRevenue'), 'url' => array('/organizationRevenue/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Organization Revenue'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>