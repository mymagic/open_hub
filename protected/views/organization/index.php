<?php
/* @var $this OrganizationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organizations',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Organization'), 'url'=>array('/organization/admin')),
	array('label'=>Yii::t('app','Create Organization'), 'url'=>array('/organization/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Organizations'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
