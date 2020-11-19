<h2>Create Experience</h2>

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'experience-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-vertical crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	)
)); ?>

<?php $this->renderPartial('_formExperience', array('model' => $model, 'form' => $form)); ?>

<?php $this->endWidget(); ?>

