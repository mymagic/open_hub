<?php
/* @var $this SampleGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sample Groups',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage SampleGroup'), 'url'=>array('/sample/sampleGroup/admin')),
	array('label'=>Yii::t('app','Create SampleGroup'), 'url'=>array('/sample/sampleGroup/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Sample Groups'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
