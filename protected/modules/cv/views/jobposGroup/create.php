<?php
/* @var $this CvJobposGroupController */
/* @var $model CvJobposGroup */

$this->breadcrumbs = array(
	'Jobpos Groups' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos Group'), 'url' => array('/cv/jobposGroup/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Jobpos Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>