<h1><?php echo $model->title; ?></h1>

<?php if (!empty(Yii::app()->user->accessBackend) && Yii::app()->user->accessBackend): ?>
<div class="box-admin-shortcut">
	<span class="edit"><a href="<?php echo  $this->createUrl('bulletin/update/', array('id' => $model->id)) ?>"><?php echo Yii::t('default', 'Edit this bulletin') ?></a></span>
</div>
<?php endif; ?>

<span class="date"><?php echo Yii::app()->dateFormatter->formatDateTime($model->date_posted, 'long', null) ?></span>
<div class="text"><?php echo $model->content ?></div>

