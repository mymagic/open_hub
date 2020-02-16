<?php
/* @var $this ClusterController */
/* @var $model Cluster */

$this->breadcrumbs=array(
	'Clusters'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Cluster'), 'url'=>array('/cluster/admin')),
	array('label'=>Yii::t('app','Create Cluster'), 'url'=>array('/cluster/create')),
	array('label'=>Yii::t('app','View Cluster'), 'url'=>array('/cluster/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Cluster'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>