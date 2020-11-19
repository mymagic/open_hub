<?php
/* @var $this CvExperienceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cv Experiences',
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvExperience'), 'url'=>array('/cv/cvExperience/admin')),
	array('label'=>Yii::t('app','Create CvExperience'), 'url'=>array('/cv/cvExperience/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Cv Experiences'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
