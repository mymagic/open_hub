<?php
/* @var $this RequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Requests',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Request'), 'url'=>array('/request/admin')),
	array('label'=>Yii::t('app','Create Request'), 'url'=>array('/request/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Requests'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
