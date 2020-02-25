<?php
/* @var $this EventOwnerController */
/* @var $model EventOwner */

$this->breadcrumbs = array(
	'Event Owners' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage EventOwner'), 'url' => array('/eventOwner/admin')),
	array('label' => Yii::t('app', 'Create EventOwner'), 'url' => array('/eventOwner/create')),
	array('label' => Yii::t('app', 'View EventOwner'), 'url' => array('/eventOwner/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event Owner'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>