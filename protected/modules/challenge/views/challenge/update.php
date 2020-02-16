<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs=array(
	'Challenges'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Challenge'), 'url'=>array('/challenge/challenge/admin')),
	array('label'=>Yii::t('app','Create Challenge'), 'url'=>array('/challenge/challenge/create')),
	array('label'=>Yii::t('app','View Challenge'), 'url'=>array('/challenge/challenge/view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete Challenge'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('backend', 'Update Challenge'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>