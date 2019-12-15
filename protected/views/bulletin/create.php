<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs=array(
	'Bulletins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('app','List Bulletin'), 'url'=>array('index')),
	array('label'=>Yii::t('app','Manage Bulletin'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Bulletin')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>