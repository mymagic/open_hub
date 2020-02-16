<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'About');
$this->breadcrumbs=array(
	Yii::t('app', 'About'),
);
?>
<?php echo Html::pageHeader(Yii::t('app', 'About')); ?>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>
