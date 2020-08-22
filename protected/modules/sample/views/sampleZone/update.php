<?php
/* @var $this SampleZoneController */
/* @var $model SampleZone */

$this->breadcrumbs = array(
	'Sample Zones' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage SampleZone'), 'url' => array('/sample/sampleZone/admin')),
	array('label' => Yii::t('app', 'Create SampleZone'), 'url' => array('/sample/sampleZone/create')),
	array('label' => Yii::t('app', 'View SampleZone'), 'url' => array('/sample/sampleZone/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Sample Zone'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>