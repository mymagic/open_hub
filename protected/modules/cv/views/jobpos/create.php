<?php
/* @var $this CvJobposController */
/* @var $model CvJobpos */

$this->breadcrumbs = array(
	'Jobpos' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos'), 'url' => array('/cv/jobpos/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Jobpos'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>