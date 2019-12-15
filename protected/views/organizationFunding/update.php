<?php
/* @var $this OrganizationFundingController */
/* @var $model OrganizationFunding */

$this->breadcrumbs=array(
	'Organization Fundings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage OrganizationFunding'), 'url'=>array('/organizationFunding/admin')),
	array('label'=>Yii::t('app','Create OrganizationFunding'), 'url'=>array('/organizationFunding/create')),
	array('label'=>Yii::t('app','View OrganizationFunding'), 'url'=>array('/organizationFunding/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Organization Funding'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>