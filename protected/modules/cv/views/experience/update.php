<?php
/* @var $this CvExperienceController */
/* @var $model CvExperience */

$this->breadcrumbs = array(
	'Cv Experiences' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage CvExperience'), 'url' => array('/cv/cvExperience/admin')),
	array('label' => Yii::t('app', 'Create CvExperience'), 'url' => array('/cv/cvExperience/create')),
	array('label' => Yii::t('app', 'View CvExperience'), 'url' => array('/cv/cvExperience/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Cv Experience'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>