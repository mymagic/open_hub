<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs = array(
	'Services' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Service'), 'url' => array('/service/admin')),
	array('label' => Yii::t('app', 'Create Service'), 'url' => array('/service/create')),
	array('label' => Yii::t('app', 'View Service'), 'url' => array('/service/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Service'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>