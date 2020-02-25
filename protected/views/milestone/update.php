<?php
/* @var $this MilestoneController */
/* @var $model Milestone */

$this->breadcrumbs = array(
	'Milestones' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Milestone'), 'url' => array('/milestone/admin')),
	array('label' => Yii::t('app', 'Create Milestone'), 'url' => array('/milestone/create')),
	array('label' => Yii::t('app', 'View Milestone'), 'url' => array('/milestone/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Milestone'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>