<?php
/* @var $this IndustryKeywordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Industry Keywords',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage IndustryKeyword'), 'url'=>array('/industryKeyword/admin')),
	array('label'=>Yii::t('app','Create IndustryKeyword'), 'url'=>array('/industryKeyword/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Industry Keywords'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
