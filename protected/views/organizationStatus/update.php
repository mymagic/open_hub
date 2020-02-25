<?php
/* @var $this OrganizationStatusController */
/* @var $model OrganizationStatus */

$this->breadcrumbs = array(
	'Organization Statuses' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage OrganizationStatus'), 'url' => array('/organizationStatus/admin')),
	array('label' => Yii::t('app', 'Create OrganizationStatus'), 'url' => array('/organizationStatus/create')),
	array('label' => Yii::t('app', 'View OrganizationStatus'), 'url' => array('/organizationStatus/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Organization Status'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>