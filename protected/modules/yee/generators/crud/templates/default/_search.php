<?php
 /*************************************************************************
 *
 * TAN YEE SIANG CONFIDENTIAL
 * __________________
 *
 *  [2002] - [2007] TAN YEE SIANG
 *  All Rights Reserved.
 *
 * NOTICE:  All information contained herein is, and remains
 * the property of TAN YEE SIANG and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to TAN YEE SIANG
 * and its suppliers and may be covered by U.S. and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from TAN YEE SIANG.
 */
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="">

<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo '<?php echo Yii::t(\'core\', \'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.\'); ?>'; ?>
<?php echo "\n"; ?>
</div>

<?php echo "<?php \$form=\$this->beginWidget('ActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal',
		'role'=>'form'
	)
)); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
	$field = $this->generateInputField($this->modelClass, $column);

	// not searchable
	// password
	if ($this->buildSetting->isPasswordColumn($column)) {
		continue;
	}
	// html
	if ($this->buildSetting->isHtmlColumn($column)) {
		continue;
	}
	// image
	if ($this->buildSetting->isImageColumn($column)) {
		continue;
	}
	// json
	if ($this->buildSetting->isJsonColumn($column)) {
		continue;
	}
?>

<?php if ($this->buildSetting->isDateColumn($column)): ?>

	<div class="form-group">
		<?php echo "<?php echo \$form->bsLabelFx2(\$model, '{$column->name}', array('required'=>false)); ?>\n"; ?>
		<label class="control-label col-sm-1"><?php echo "<?php echo Yii::t('backend', 'Start') ?>" ?></label>
		<div class="col-sm-4">
			<?php echo "<?php echo \$form->bsDateTextField(\$model, 's{$column->name}', array('nullable'=>true, 'class'=>'dateRange-start')); ?>\n" ?>
		</div>
		<label class="control-label col-sm-1"><?php echo "<?php echo Yii::t('backend', 'End') ?>" ?></label>
		<div class="col-sm-4">
			<?php echo "<?php echo \$form->bsDateTextField(\$model, 'e{$column->name}', array('nullable'=>true, 'class'=>'dateRange-end')); ?>\n" ?>
		</div>
	</div>

<?php else: ?>

	<?php if (ysUtil::isLanguageField($column->name)): ?><?php $languageKey = ysUtil::getLanguageKey($column->name); ?><?php echo "<?php if(array_key_exists('{$languageKey}', Yii::app()->params['backendLanguages'])): ?>\n"; ?><?php endif; ?>
	
	<div class="form-group">
		<?php echo "<?php echo \$form->bsLabelFx2(\$model, '{$column->name}', array('required'=>false)); ?>\n"; ?>
		<div class="col-sm-10">
			<?php echo '<?php echo ' . $this->generateActiveField($this->modelClass, $column, 'search') . "; ?>\n"; ?>
		</div>
	</div>
	
	<?php if (ysUtil::isLanguageField($column->name)): ?><?php echo "<?php endif; ?>\n"; ?><?php endif; ?>
	
<?php endif; ?>
	
<?php endforeach; ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo "<?php echo \$form->bsBtnSubmit(Yii::t('core', 'Search')); ?>\n"; ?>
			<?php echo "<?php echo Html::btnDanger(Yii::t('core', 'Reset'), Yii::app()->createUrl(\$this->route, array('clearFilters'=>'1'))) ?>\n"; ?>
		</div>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->