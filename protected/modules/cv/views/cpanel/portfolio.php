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


    <div class="form-group <?php echo $model->hasErrors('visibility') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx3($model, 'visibility'); ?>
        <div class="col-sm-9">
            <?php echo $form->bsEnumDropDownList($model, 'visibility'); ?>
            <?php echo $form->bsError($model, 'visibility'); ?>
        </div>
    </div>

    <div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx3($model, 'slug'); ?>
        <div class="col-sm-2">
            <?php echo $form->bsTextField($model, 'slug'); ?>
            <?php echo $form->bsError($model, 'slug'); ?>
        </div>
    </div>
            
    <div class="form-group <?php echo $model->hasErrors('display_name') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx3($model, 'display_name'); ?>
        <div class="col-sm-5">
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

    <div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx3($model, 'text_short_description'); ?>
        <div class="col-sm-9">
            <?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
            <?php echo $form->bsError($model, 'text_short_description'); ?>
        </div>
    </div>

    <div class="form-group <?php echo $model->hasErrors('text_address_residential') ? 'has-error' : '' ?>">
        <?php echo $form->bsLabelEx3($model, 'text_address_residential'); ?>
        <div class="col-sm-9">
            <?php echo $form->bsTextArea($model, 'text_address_residential', array('rows' => 2)); ?>
            <?php echo $form->bsError($model, 'text_address_residential'); ?>
        </div>
    </div>

    <div class="form-group">
        <label class=" control-label col-sm-3" for=""><?php echo Yii::t('cv', 'Social Links')?></label>
        <div class="col-sm-9">
            
                <div class="input-group">
                    <div class="input-group-addon bg-default btn-sm" id=""><?php echo Html::faIcon('fa-globe fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_website', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlWebsite"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_website'); ?>

                <div class="input-group">
                    <div class="input-group-addon bg-default btn-sm" id=""><?php echo Html::faIcon('fa-linkedin fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_linkedin', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlLinkedin"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_linkedin'); ?>

                <div class="input-group margin-top-sm">
                    <div class="input-group-addon bg-default btn-sm" id=""><?php echo Html::faIcon('fa-facebook fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_facebook', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlFacebook"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_facebook'); ?>

                <div class="input-group margin-top-sm">
                    <div class="input-group-addon bg-default btn-sm" id=""><?php echo Html::faIcon('fa-twitter fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_twitter', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlTwitter"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_twitter'); ?>

                <div class="input-group margin-top-sm">
                    <div class="input-group-addon bg-default btn-sm"><?php echo Html::faIcon('fa-github fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_github', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlGithub"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_github'); ?>

                <div class="input-group margin-top-sm">
                    <div class="input-group-addon bg-default btn-sm"><?php echo Html::faIcon('fa-stack-overflow fa-fw') ?></div>
                    <?php echo $form->bsTextField($model, 'url_stackoverflow', array('placeholder' => 'http://')); ?>
                    <a class="btn btn-success input-group-addon" id="btn-urlStackoverflow"><?php echo Html::faIcon('fa-external-link') ?></a>
                </div>
                <?php echo $form->bsError($model, 'url_stackoverflow'); ?>
            
        </div>
    </div>

    <div class="form-group">
        <label class=" control-label col-sm-3" for=""><?php echo Yii::t('cv', 'I am looking for')?></label>
        <div class="col-sm-9">
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_fulltime'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_fulltime') ?></span>
            </label></div>
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_contract'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_contract') ?></span>
            </label></div>
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_freelance'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_freelance') ?></span>
            </label></div>
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_cofounder'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_cofounder') ?></span>
            </label></div>
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_internship'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_internship') ?></span>
            </label></div>
            <div class="col-xs-6 col-sm-4"><label class="checkbox-inline">
                <?php echo $form->bsCheckbox($model, 'is_looking_apprenticeship'); ?>
                <span><?php echo $model->getAttributeLabel('is_looking_apprenticeship') ?></span>
            </label></div>
        </div>
    </div>
        
    <!-- many2many -->
    <!-- /many2many -->

    <div class="form-group margin-top-2x">
        <div class="col-sm-offset-2 col-sm-9">
            <?php echo $form->bsBtnSubmit(Yii::t('core', 'Save')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>