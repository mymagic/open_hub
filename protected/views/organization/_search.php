<?php
/* @var $this OrganizationController */
/* @var $model Organization */
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
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	)
)); ?>


	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'slug', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'title', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'legal_name', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'legal_name'); ?>
		</div>
	</div>
		
		
	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'company_number', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'company_number'); ?>
		</div>
	</div>
	

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'url_website', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'inputPersonas', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'inputIndustries', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'inputImpacts', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputImpacts', Html::listData(Impact::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'inputSdgs', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputSdgs', Html::listData(Sdg::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'inputCountries', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputCountries', Html::listData(Country::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->bsLabelFx2($model, 'searchBackendTags', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputBackendTags', Html::listData(Tag::getForeignReferList()), array('class' => 'form-control chosen', 'multiple' => 'multiple')); ?>
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