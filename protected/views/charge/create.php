<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs = array(
	'Charges' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Charge'), 'url' => array('/charge/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Charge'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>