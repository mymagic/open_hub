<?php
/* @var $this ChallengeController */
/* @var $model Challenge */

$this->breadcrumbs=array(
	'Challenges'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Challenge'), 'url'=>array('/challenge/challenge/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Challenge'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>