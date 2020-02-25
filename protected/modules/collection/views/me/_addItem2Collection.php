  
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h5 class="modal-title">Add to Collection</h5>
    </div>
    <?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'collection-form',
	'action' => Yii::app()->createUrl('/collection/me/addItem2Collection', array('tableName' => $tableName, 'refId' => $refId)),
	  // Please note: When you enable ajax validation, make sure the corresponding
	  // controller action is handling ajax validation correctly.
	  // There is a call to performAjaxValidation() commented in generated controller code.
	  // See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'clientOptions' => array(
	  'validateOnSubmit' => true,
	  'afterValidate' => 'js:onAddItem2CollectionValidated'
	),
	  'htmlOptions' => array(
	  'class' => 'form-horizontal crud-form',
	  'role' => 'form',
	  'enctype' => 'multipart/form-data',
	  ),
	)); ?>
    <div class="modal-body">
      <div class="row">
        <div class="col col-sm-7">

          <div class="form-group <?php echo $model->hasErrors('collection') ? 'has-error' : ''; ?>">
            <?php echo $form->bsLabelEx4($model, 'collection'); ?>
            <div class="col-sm-8">
              <?php echo $form->bsTextField($model, 'collection'); ?>
              <?php echo $form->bsError($model, 'collection'); ?>
            </div>
          </div>	
          <div class="form-group <?php echo $model->hasErrors('collectionSub') ? 'has-error' : ''; ?>">
            <?php echo $form->bsLabelEx4($model, 'collectionSub'); ?>
            <div class="col-sm-8">
              <?php echo $form->bsTextField($model, 'collectionSub'); ?>
              <?php echo $form->bsError($model, 'collectionSub'); ?>
            </div>
          </div>	

        </div>
        <div class="col col-sm-5">
          <div class="gray-bg padding-lg text-center rounded-md">
            <?php echo HubCollection::renderCollectionItem($this, $item); ?>
            <?php if (Yii::app()->params['dev']): ?><p><?php echo $tableName; ?> - #<?php echo $refId; ?></p><?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <?php echo $form->bsBtnSubmit(Yii::t('core', 'Save')); ?>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
    <?php $this->endWidget(); ?>
  </div>
</div>