<?php
/* @var $this CvJobposGroupController */
/* @var $model CvJobposGroup */

$this->breadcrumbs = array(
	'Jobpos Groups' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Jobpos Group'), 'url' => array('/cv/jobposGroup/admin')),
	array('label' => Yii::t('app', 'Create Jobpos Group'), 'url' => array('/cv/jobposGroup/create')),
	array('label' => Yii::t('app', 'View Jobpos Group'), 'url' => array('/cv/jobposGroup/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Jobpos Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>