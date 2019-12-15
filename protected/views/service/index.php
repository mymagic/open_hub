<?php
/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Services',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Service'), 'url'=>array('/service/admin')),
	array('label'=>Yii::t('app','Create Service'), 'url'=>array('/service/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Services'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
