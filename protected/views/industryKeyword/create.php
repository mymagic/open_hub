<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */

$this->breadcrumbs=array(
	'Industry Keywords'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage IndustryKeyword'), 'url'=>array('/industryKeyword/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Industry Keyword'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>