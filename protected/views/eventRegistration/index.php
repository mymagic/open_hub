<?php
/* @var $this EventRegistrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Registrations',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage EventRegistration'), 'url'=>array('/eventRegistration/admin')),
	array('label'=>Yii::t('app','Create EventRegistration'), 'url'=>array('/eventRegistration/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Event Registrations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
