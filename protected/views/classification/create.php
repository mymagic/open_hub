<?php
/* @var $this ClassificationController */
/* @var $model Classification */

$this->breadcrumbs = array(
	'Classifications' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Classification'), 'url' => array('/classification/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Classification'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>