<?php
/* @var $this SampleZoneController */
/* @var $model SampleZone */

$this->breadcrumbs = array(
	'Sample Zones' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage SampleZone'), 'url' => array('/sample/sampleZone/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Sample Zone'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>