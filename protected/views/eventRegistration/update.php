<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */

$this->breadcrumbs=array(
	'Event Registrations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage EventRegistration'), 'url'=>array('/eventRegistration/admin')),
	array('label'=>Yii::t('app','Create EventRegistration'), 'url'=>array('/eventRegistration/create')),
	array('label'=>Yii::t('app','View EventRegistration'), 'url'=>array('/eventRegistration/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event Registration'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>