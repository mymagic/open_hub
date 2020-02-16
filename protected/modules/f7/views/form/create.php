<?php
/* @var $this FormController */
/* @var $model Form */

$this->breadcrumbs=array(
	'Forms'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Form'), 'url'=>array('/f7/form/admin')),
	array('label'=>Yii::t('app','Build Form'), 'url'=>array('/f7/form/builder'),'linkOptions' => array('target' => '_blank')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Form'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>