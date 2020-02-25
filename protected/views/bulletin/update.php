<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs = array(
	'Bulletins' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List Bulletin'), 'url' => array('index')),
	array('label' => Yii::t('app', 'Create Bulletin'), 'url' => array('create')),
	array('label' => Yii::t('app', 'View Bulletin'), 'url' => array('view', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Manage Bulletin'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Bulletin')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>