<?php
/* @var $this IntakeController */
/* @var $model Intake */

$this->breadcrumbs = array(
	'Intakes' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Intake'), 'url' => array('/f7/intake/admin')),
	array('label' => Yii::t('app', 'Create Intake'), 'url' => array('/f7/intake/create')),
	array('label' => Yii::t('app', 'View Intake'), 'url' => array('/f7/intake/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Intake'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>