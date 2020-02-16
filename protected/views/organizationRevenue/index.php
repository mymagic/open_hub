<?php
/* @var $this OrganizationRevenueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organization Revenues',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage OrganizationRevenue'), 'url'=>array('/organizationRevenue/admin')),
	array('label'=>Yii::t('app','Create OrganizationRevenue'), 'url'=>array('/organizationRevenue/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Organization Revenues'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
