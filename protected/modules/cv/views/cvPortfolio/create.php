<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs=array(
	'Cv Portfolios'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvPortfolio'), 'url'=>array('/cv/cvPortfolio/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Cv Portfolio'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>