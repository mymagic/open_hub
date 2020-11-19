<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */

$this->breadcrumbs = array(
	'Portfolios' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Portfolio'), 'url' => array('/cv/portfolio/admin')),
	array('label' => Yii::t('app', 'Create Portfolio'), 'url' => array('/cv/portfolio/create')),
	array('label' => Yii::t('app', 'View Portfolio'), 'url' => array('/cv/portfolio/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Portfolio'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>