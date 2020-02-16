<?php
/* @var $this SampleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Samples',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Sample'), 'url'=>array('/sample/sample/admin')),
	array('label'=>Yii::t('app','Create Sample'), 'url'=>array('/sample/sample/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Samples'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
