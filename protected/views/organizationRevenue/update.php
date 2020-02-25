<?php
/* @var $this OrganizationRevenueController */
/* @var $model OrganizationRevenue */

$this->breadcrumbs = array(
	'Organization Revenues' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage OrganizationRevenue'), 'url' => array('/organizationRevenue/admin')),
	array('label' => Yii::t('app', 'Create OrganizationRevenue'), 'url' => array('/organizationRevenue/create')),
	array('label' => Yii::t('app', 'View OrganizationRevenue'), 'url' => array('/organizationRevenue/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Organization Revenue'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>