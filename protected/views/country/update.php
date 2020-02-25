<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs = array(
	'Countries' => array('index'),
	$model->name => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Country'), 'url' => array('/country/admin')),
	array('label' => Yii::t('app', 'Create Country'), 'url' => array('/country/create')),
	array('label' => Yii::t('app', 'View Country'), 'url' => array('/country/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Country'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>