<?php
/* @var $this JunkController */
/* @var $model Junk */

$this->breadcrumbs = array(
	'Junks' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Junk'), 'url' => array('/junk/admin')),
	array('label' => Yii::t('app', 'Create Junk'), 'url' => array('/junk/create')),
	array('label' => Yii::t('app', 'View Junk'), 'url' => array('/junk/view', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Junk'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('backend', 'Update Junk'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>