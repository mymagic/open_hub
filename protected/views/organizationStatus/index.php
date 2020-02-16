<?php
/* @var $this OrganizationStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organization Statuses',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage OrganizationStatus'), 'url'=>array('/organizationStatus/admin')),
	array('label'=>Yii::t('app','Create OrganizationStatus'), 'url'=>array('/organizationStatus/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Organization Statuses'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
