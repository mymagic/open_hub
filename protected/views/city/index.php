<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cities',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage City'), 'url'=>array('/city/admin')),
	array('label'=>Yii::t('app','Create City'), 'url'=>array('/city/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Cities'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
