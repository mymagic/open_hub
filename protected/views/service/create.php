<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs = array(
	'Services' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Service'), 'url' => array('/service/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Service'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>