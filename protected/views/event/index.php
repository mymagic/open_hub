<?php
/* @var $this EventController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Events',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Event'), 'url'=>array('/event/admin')),
	array('label'=>Yii::t('app','Create Event'), 'url'=>array('/event/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Events'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
