<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs = array(
	'Portfolios' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Portfolio'), 'url' => array('/cv/portfolio/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Portfolio'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>