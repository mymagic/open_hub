<?php
/* @var $this CvPortfolioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Portfolios',
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage CvPortfolio'), 'url' => array('/cv/portfolio/admin')),
	array('label' => Yii::t('app', 'Create CvPortfolio'), 'url' => array('/cv/portfolio/create')),
);
?>

<h1><?php echo Yii::t('backend', 'Portfolios'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
