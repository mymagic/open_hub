<?php
/* @var $this ImpactController */
/* @var $model Impact */

$this->breadcrumbs = array(
	'Impacts' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Impact'), 'url' => array('/impact/admin')),
	array('label' => Yii::t('app', 'Create Impact'), 'url' => array('/impact/create')),
	array('label' => Yii::t('app', 'View Impact'), 'url' => array('/impact/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Impact'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>