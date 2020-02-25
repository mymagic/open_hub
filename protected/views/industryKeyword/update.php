<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */

$this->breadcrumbs = array(
	'Industry Keywords' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage IndustryKeyword'), 'url' => array('/industryKeyword/admin')),
	array('label' => Yii::t('app', 'Create IndustryKeyword'), 'url' => array('/industryKeyword/create')),
	array('label' => Yii::t('app', 'View IndustryKeyword'), 'url' => array('/industryKeyword/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Industry Keyword'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>