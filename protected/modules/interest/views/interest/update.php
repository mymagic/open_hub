<?php
/* @var $this InterestController */
/* @var $model Interest */

$this->breadcrumbs = array(
	'Interests' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List Interest'), 'url' => array('/interest/interest/index')),
	array('label' => Yii::t('app', 'Create Interest'), 'url' => array('/interest/interest/create')),
	array('label' => Yii::t('app', 'View Interest'), 'url' => array('/interest/interest/view', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Manage Interest'), 'url' => array('/interest/interest/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Update Interest'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>