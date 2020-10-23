<?php
/* @var $this CvJobposGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cv Jobpos Groups',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/admin')),
	array('label'=>Yii::t('app','Create CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Cv Jobpos Groups'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
