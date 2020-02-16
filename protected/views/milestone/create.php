<?php
/* @var $this MilestoneController */
/* @var $model Milestone */

$this->breadcrumbs=array(
	'Milestones'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage All Milestone'), 'url'=>array('/milestone/admin')),
	array('label'=>Yii::t('app','Manage Revenue Milestone'), 'url'=>array('/milestone/adminRevenue')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Milestone'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>