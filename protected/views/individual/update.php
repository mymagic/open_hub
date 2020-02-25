<?php
/* @var $this IndividualController */
/* @var $model Individual */

$this->breadcrumbs = array(
	'Individuals' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Individual'), 'url' => array('/individual/admin')),
	array('label' => Yii::t('app', 'Create Individual'), 'url' => array('/individual/create')),
	array('label' => Yii::t('app', 'View Individual'), 'url' => array('/individual/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Individual'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>