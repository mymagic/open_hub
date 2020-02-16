<?php
/* @var $this EventGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Groups',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage EventGroup'), 'url'=>array('/eventGroup/admin')),
	array('label'=>Yii::t('app','Create EventGroup'), 'url'=>array('/eventGroup/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Event Groups'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
