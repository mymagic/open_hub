<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'experience-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'afterValidate' => 'js:onAddExperienceValidated'
	),
	'htmlOptions' => array(
		'class' => 'form-vertical crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	)
)); ?>

<div class="modal-dialog <?php echo $this->layoutParams['modalDialogClass'] ?>" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $this->pageTitle ?></h4>
    </div>
    <div class="modal-body">
		<?php $this->renderPartial('_formExperience', array('model' => $model, 'form' => $form)); ?>
    </div>
    <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app', 'Cancel') ?></button>
		<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save'));?>
    </div>
</div>
</div>

	

<?php $this->endWidget(); ?>


<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/cpanel.js', CClientScript::POS_END); ?>