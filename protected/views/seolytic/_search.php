<?php
/* @var $this SeolyticController */
/* @var $model Seolytic */
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
		<?php echo $form->bsLabelFx2($model, 'id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'id'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'path_pattern', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'path_pattern'); ?>
		</div>
	</div>
	
		
	


	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_en', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_en'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_ms', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_ms'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title_zh', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title_zh'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'description_en', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'description_en'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'description_ms', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'description_ms'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'description_zh', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'description_zh'); ?>
		</div>
	</div>
	
	<?php endif; ?>
	
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'js_header', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'js_header', array('rows' => 5)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'js_footer', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'js_footer', array('rows' => 5)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'css_header', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'css_header', array('rows' => 5)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_active', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'ordering', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ordering'); ?>
		</div>
	</div>
	
		
	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_added', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_added', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_added', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'date_modified', array('required' => false)); ?>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'Start') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'sdate_modified', array('nullable' => true, 'class' => 'dateRange-start')); ?>
		</div>
		<label class="control-label col-sm-1"><?php echo Yii::t('backend', 'End') ?></label>
		<div class="col-sm-4">
			<?php echo $form->bsDateTextField($model, 'edate_modified', array('nullable' => true, 'class' => 'dateRange-end')); ?>
		</div>
	</div>

	

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Search')); ?>
			<?php echo Html::btnDanger(Yii::t('core', 'Reset'), Yii::app()->createUrl($this->route, array('clearFilters' => '1'))) ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->