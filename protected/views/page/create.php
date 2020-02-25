<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs = array(
	'Pages' => array('index'),
	'Create',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Page'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Page')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>