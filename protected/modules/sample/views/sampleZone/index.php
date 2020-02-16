<?php
/* @var $this SampleZoneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sample Zones',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage SampleZone'), 'url'=>array('/sample/sampleZone/admin')),
	array('label'=>Yii::t('app','Create SampleZone'), 'url'=>array('/sample/sampleZone/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Sample Zones'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
