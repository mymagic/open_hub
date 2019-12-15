<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Faq'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Faq'), 'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Faq')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>