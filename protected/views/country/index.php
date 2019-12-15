<?php
/* @var $this CountryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Countries',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Country'), 'url'=>array('/country/admin')),
	array('label'=>Yii::t('app','Create Country'), 'url'=>array('/country/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Countries'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
