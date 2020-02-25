<?php
/* @var $this BulletinController */
/* @var $model Bulletin */
/* @var $form CActiveForm */
?>

<div class="">

<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo Yii::t('core', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</div>

<?php $form = $this->beginWidget('ActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>

	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'id'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'title_en'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_en'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'title_ms'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_ms'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'title_zh'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_zh'); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'text_short_description_en'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description_en', array('rows' => 2)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'text_short_description_ms'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description_ms', array('rows' => 2)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'text_short_description_zh'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description_zh', array('rows' => 2)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_posted'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_posted', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_public'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_public', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_member'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_member', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'is_admin'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_admin', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_added'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_added', array('nullable' => true)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model, 'date_modified'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_modified', array('nullable' => true)); ?>
		</div>
	</div>
	

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Search')); ?>
			<?php echo Html::btnDanger(Yii::t('core', 'Reset'), Yii::app()->createUrl($this->route)) ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->