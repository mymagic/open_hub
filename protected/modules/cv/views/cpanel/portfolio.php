<div class="px-8 py-6 shadow-panel">
    <h2>Manage Portfolio</h2>
    <p></p>



    <div class="form-new org-padding">

    <?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'cv-portfolio-form',
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

    <?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
    <?php if ($model->hasErrors()): ?>
        <?php echo $form->bsErrorSummary($model); ?>
    <?php endif; ?>



        <div class="form-group <?php echo $model->hasErrors('visibility') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'visibility'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsEnumDropDownList($model, 'visibility'); ?>
                <?php echo $form->bsError($model, 'visibility'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'slug'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsTextField($model, 'slug'); ?>
                <?php echo $form->bsError($model, 'slug'); ?>
            </div>
        </div>

        <div class="form-group <?php echo $model->hasErrors('display_name') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'display_name'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsTextField($model, 'display_name'); ?>
                <?php echo $form->bsError($model, 'display_name'); ?>
            </div>
        </div>

        <div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'text_oneliner'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsTextField($model, 'text_oneliner'); ?>
                <?php echo $form->bsError($model, 'text_oneliner'); ?>
            </div>
        </div>

        <div class="form-group <?php echo $model->hasErrors('image_avatar') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'image_avatar'); ?>
            <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-2 text-left">
                <?php echo Html::activeThumb($model, 'image_avatar'); ?>
                </div>
                <div class="col-sm-8">
                <?php echo Html::activeFileField($model, 'imageFile_avatar'); ?>
                <?php echo $form->bsError($model, 'image_avatar'); ?>
                </div>
            </div>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('text_address_residential') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'text_address_residential'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsTextArea($model, 'text_address_residential', array('rows' => 2)); ?>
                <?php echo $form->bsError($model, 'text_address_residential'); ?>
            </div>
        </div>



        <div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'text_short_description'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
                <?php echo $form->bsError($model, 'text_short_description'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_fulltime') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_fulltime'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_fulltime'); ?>
                <?php echo $form->bsError($model, 'is_looking_fulltime'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_contract') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_contract'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_contract'); ?>
                <?php echo $form->bsError($model, 'is_looking_contract'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_freelance') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_freelance'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_freelance'); ?>
                <?php echo $form->bsError($model, 'is_looking_freelance'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_cofounder') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_cofounder'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_cofounder'); ?>
                <?php echo $form->bsError($model, 'is_looking_cofounder'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_internship') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_internship'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_internship'); ?>
                <?php echo $form->bsError($model, 'is_looking_internship'); ?>
            </div>
        </div>


        <div class="form-group <?php echo $model->hasErrors('is_looking_apprenticeship') ? 'has-error' : '' ?>">
            <?php echo $form->bsLabelEx3($model, 'is_looking_apprenticeship'); ?>
            <div class="col-sm-9">
                <?php echo $form->bsBooleanList($model, 'is_looking_apprenticeship'); ?>
                <?php echo $form->bsError($model, 'is_looking_apprenticeship'); ?>
            </div>
        </div>




            
        <!-- many2many -->
        <!-- /many2many -->

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <?php echo $form->bsBtnSubmit(Yii::t('core', 'Save')); ?>
            </div>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>