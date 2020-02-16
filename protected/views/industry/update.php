<?php
/* @var $this IndustryController */
/* @var $model Industry */

$this->breadcrumbs=array(
	'Industries'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Industry'), 'url'=>array('/industry/admin')),
	array('label'=>Yii::t('app','Create Industry'), 'url'=>array('/industry/create')),
	array('label'=>Yii::t('app','View Industry'), 'url'=>array('/industry/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Industry'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>