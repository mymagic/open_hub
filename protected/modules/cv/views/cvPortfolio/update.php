<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs=array(
	'Cv Portfolios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvPortfolio'), 'url'=>array('/cv/cvPortfolio/admin')),
	array('label'=>Yii::t('app','Create CvPortfolio'), 'url'=>array('/cv/cvPortfolio/create')),
	array('label'=>Yii::t('app','View CvPortfolio'), 'url'=>array('/cv/cvPortfolio/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Cv Portfolio'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>