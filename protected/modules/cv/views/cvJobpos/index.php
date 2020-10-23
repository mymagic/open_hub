<?php
/* @var $this CvJobposController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cv Jobposes',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobpos'), 'url'=>array('/cv/cvJobpos/admin')),
	array('label'=>Yii::t('app','Create CvJobpos'), 'url'=>array('/cv/cvJobpos/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Cv Jobposes'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
