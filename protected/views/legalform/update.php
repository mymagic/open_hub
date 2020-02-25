<?php
/* @var $this LegalformController */
/* @var $model Legalform */

$this->breadcrumbs = array(
	'Legalforms' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Legalform'), 'url' => array('/legalform/admin')),
	array('label' => Yii::t('app', 'Create Legalform'), 'url' => array('/legalform/create')),
	array('label' => Yii::t('app', 'View Legalform'), 'url' => array('/legalform/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Legalform'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>