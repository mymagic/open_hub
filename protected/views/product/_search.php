<?php
/* @var $this ProductController */
/* @var $model Product */
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
		<?php echo $form->bsLabelFx2($model, 'organization_id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'organization_id', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'product_category_id', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'product_category_id', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'text_short_description', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'typeof', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'typeof', array('nullable' => true)); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'url_website', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
		</div>
	</div>
	
		
	


		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'is_active', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active', array('nullable' => true)); ?>
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