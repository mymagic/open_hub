<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs = array(
	'Admins' => array('index'),
	'Create',
);

$this->menu = array(
	array('label' => Yii::t('backend', 'Manage Admin'), 'url' => array('/admin/admin')),
	array('label' => Yii::t('backend', 'Create Admin'), 'url' => array('/admin/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Admin'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>