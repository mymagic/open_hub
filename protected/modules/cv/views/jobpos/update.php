<?php
/* @var $this CvJobposController */
/* @var $model CvJobpos */

$this->breadcrumbs = array(
	'Jobpos' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos'), 'url' => array('/cv/jobpos/admin')),
	array('label' => Yii::t('app', 'Create Jobpos'), 'url' => array('/cv/jobpos/create')),
	array('label' => Yii::t('app', 'View Jobpos'), 'url' => array('/cv/jobpos/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Jobpos'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>