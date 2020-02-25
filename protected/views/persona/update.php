<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs = array(
	'Personas' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Persona'), 'url' => array('/persona/admin')),
	array('label' => Yii::t('app', 'Create Persona'), 'url' => array('/persona/create')),
	array('label' => Yii::t('app', 'View Persona'), 'url' => array('/persona/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Persona'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>