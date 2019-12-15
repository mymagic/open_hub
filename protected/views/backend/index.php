<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Admin'),
);?>
<h1><?php echo Yii::t('app', 'Backend') ?></h1>

<div class="panel panel-default">
	<div class="panel-heading"><?php echo Yii::t('app', 'Welcome'); ?>: <?php echo $this->user->profile->full_name; ?> (<?php echo $this->user->nickname; ?>)</div>
	 <div class="panel-body">
		<p><?php echo Yii::t('app', 'Role'); ?>: <?php echo Yii::app()->user->roleLevelDisplay;	?></p>
	</div>
</div>

<ul>
	<li><?php echo Html::link(Yii::t('app', 'Bulletin'), array('bulletin/admin')) ?></li>
	<li><?php echo Html::link(Yii::t('app', 'Sample Group'), array('sampleGroup/admin')) ?></li>
	<li><?php echo Html::link(Yii::t('app', 'Sample Zone'), array('sampleZone/admin')) ?></li>
	<li><?php echo Html::link(Yii::t('app', 'Sample'), array('sample/admin')) ?></li>
</ul>