<?php
/* @var $this CvJobposController */
/* @var $model CvJobpos */

$this->breadcrumbs=array(
	'Cv Jobposes'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobpos'), 'url'=>array('/cv/cvJobpos/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Cv Jobpos'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>