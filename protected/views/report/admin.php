<?php
/* @var $this MapApplicationController */
/* @var $model MapApplication */

$this->breadcrumbs=array(
	Yii::t('backend', 'Report')=>array('index'),
	Yii::t('backend', 'Admin'),
);
?>

<h1><?php echo Yii::t('backend', 'Reporting'); ?></h1>

<div class="row">
<div class="col-lg-4">
	<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>General</h5>
	</div>
	<div class="ibox-content">
		<?php echo Html::link('Daily New Applications (This Batch)', $this->createUrl('report/exportThisBatchDailyNewApplication')) ?><span class="badge pull-right">CSV</span>
	</div>
	</div>
</div>
<div class="col-lg-4">
	<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>ASEAN</h5>
	</div>
	<div class="ibox-content">
		<?php echo Html::link('All Applications (This Batch)', $this->createUrl('report/exportAllThisBatchMapApplication')) ?><span class="badge pull-right">CSV</span>
	</div>
	</div>
</div>
<div class="col-lg-4">
	<div class="ibox float-e-margins">
	<div class="ibox-title">
		<h5>Social Enterprise</h5>
	</div>
	<div class="ibox-content">
		<?php echo Html::link('All Applications (This Batch)', $this->createUrl('report/exportAllThisBatchSeApplication')) ?><span class="badge pull-right">CSV</span>
	</div>
	</div>
</div>
</div>