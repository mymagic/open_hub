<?php
/* @var $this Resource2OrganizationFundingController */
/* @var $model Resource2OrganizationFunding */

$this->breadcrumbs = array(
	'Resource2 Organization Fundings' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/admin')),
	array('label' => Yii::t('app', 'Create Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/create')),
	array('label' => Yii::t('app', 'View Resource2OrganizationFunding'), 'url' => array('/resource2OrganizationFunding/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Resource2 Organization Funding'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>