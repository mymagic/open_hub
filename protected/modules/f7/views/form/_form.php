<?php
/* @var $this FormController */
/* @var $model Form */
/* @var $form CActiveForm */
?>

<?php 
	// codemirror
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/edit/matchbrackets.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/addon/scroll/simplescrollbars.js', CClientScript::POS_END);

	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/javascript/javascript.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/mode/clike/clike.js', CClientScript::POS_END);

	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/lib/codemirror.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/codemirror/theme/midnight.css');
?>

<div class="">

	<?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'form-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
		'htmlOptions' => array(
			'class' => 'form-horizontal crud-form',
			'role' => 'form',
			'enctype' => 'multipart/form-data',
		)
	)); ?>

	<?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
	<?php if ($model->hasErrors()) : ?>
		<?php echo $form->bsErrorSummary($model); ?>
	<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_note') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_note', array('rows' => 2)); ?>
			<span class="help-block">only viewable in backend</span>
			<?php echo $form->bsError($model, 'text_note'); ?>
		</div>
	</div>

	<?php $js = CJSON::decode($model->json_structure); ?>
	<div class="form-group <?php echo $model->hasErrors('json_structure') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_structure'); ?>
		<div class="col-sm-10">
			<?php if (!array_key_exists('builder', $js) && !empty($model->json_structure)) {
		?>
				<?php echo $form->bsTextArea($model, 'json_structure', array('rows' => 20)); ?>
				<?php echo $form->bsError($model, 'json_structure'); ?>
			<?php
	} else {
		?>
				<br>
				<json-form-structure json='<?php echo ($model->json_structure) ? htmlentities(json_encode($model->json_structure, true), ENT_QUOTES, 'UTF-8') : 'null' ?>'></json-form-structure>
			<?php
	} ?>
		</div>
	</div>

	<!-- <div class="form-group <?php echo $model->hasErrors('json_structure') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_structure'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_structure', array('rows' => 20)); ?>
			<?php echo $form->bsError($model, 'json_structure'); ?>
		</div>
	</div> -->



	<div class="form-group <?php echo $model->hasErrors('timezone') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'timezone'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'timezone'); ?>
			<?php echo $form->bsError($model, 'timezone'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('date_open') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_open'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTimeTextField($model, 'date_open', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_open'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_close') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_close'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTimeTextField($model, 'date_close', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_close'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('type') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'Survey'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'type'); ?>
			<?php echo $form->bsError($model, 'type'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_multiple') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_multiple'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_multiple'); ?>
			<?php echo $form->bsError($model, 'is_multiple'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_login_required') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_login_required'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_login_required'); ?>
			<?php echo $form->bsError($model, 'is_login_required'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('json_stage') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_stage'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_stage', array('rows' => 4)); ?>
			<?php echo $form->bsError($model, 'json_stage'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('json_event_mapping') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_event_mapping'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_event_mapping', array('rows' => 4)); ?>
			<?php echo $form->bsError($model, 'json_event_mapping'); ?>
		</div>
	</div>


	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save'), array('id' => 'btn-submit')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->


<?php 
// Yii::app()->clientScript->registerScript('f7-form-_form', "
// $('#Form_json_structure').bind('change paste', function(e){
// 	var str = $(this).val();
// 	var result = false;
// 	try {
// 		JSON.parse(str);
// 		result = true;
//     } catch (e) {
// 		$('#btn-submit').addClass('disabled').attr('disabled', true);
// 		return;
// 	}

// 	if(result) $('#btn-submit').removeClass('disabled').removeAttr('disabled', true);
// } );
// ");
?>

<?php Yii::app()->clientScript->registerScript('js-f7-form-_form', <<<JS

document.getElementById('Form_json_structure').value = JSON.stringify(JSON.parse(document.getElementById('Form_json_structure').value), undefined, 4);

document.getElementById('Form_json_stage').value = JSON.stringify(JSON.parse(document.getElementById('Form_json_stage').value), undefined, 4);

document.getElementById('Form_json_event_mapping').value = JSON.stringify(JSON.parse(document.getElementById('Form_json_event_mapping').value), undefined, 4);

/*var editor = CodeMirror.fromTextArea(document.getElementById("Form_json_stage"), {
    htmlMode: true,
    lineNumbers: true,
    matchBrackets: true,
    mode: "application/json",
    indentUnit: 4,
    indentWithTabs: true,
    lineWrapping: true,
    scrollbarStyle: 'simple',
    theme:'midnight',   
});*/
JS
, CClientScript::POS_READY); ?>