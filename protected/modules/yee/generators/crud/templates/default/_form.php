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

<?php 
	$many2many = $this->buildSetting->getMany2Many();
	$spatials = $this->buildSetting->getSpatialColumns();
?>

<div class="">

<?php echo "<?php \$form=\$this->beginWidget('ActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal crud-form',
		'role'=>'form',
		'enctype'=>'multipart/form-data',
	)
)); ?>\n"; ?>

<?php echo '<?php echo Notice::inline(Yii::t(\'core\', \'Fields with <span class="required">*</span> are required.\')); ?>'; ?>

<?php echo "<?php if(\$model->hasErrors()): ?>\n"; ?>
	<?php echo "<?php echo \$form->bsErrorSummary(\$model); ?>\n"; ?>
<?php echo '<?php endif; ?>'; ?>

<?php $countLanguageField = 0; foreach ($this->tableSchema->columns as $column): ?>
<?php 
//echo "--".$this->buildSetting->isJsonColumn('json_extra')."--";exit;
	if (
		$column->autoIncrement ||
		$this->buildSetting->isOrderingColumn($column) ||
		$column->name == 'date_added' ||
		$column->name == 'date_modified' ||
		$this->buildSetting->isJsonColumn($column) ||
		$this->buildSetting->isUUIDColumn($column) ||
		$this->buildSetting->isHiddenInFormColumn($column)
	) {
		continue;
	}
?>
<?php if (!ysUtil::isLanguageField($column->name)): ?>
<?php echo "\n\n"; ?>
	<div class="form-group <?php echo "<?php echo \$model->hasErrors('{$column->name}') ? 'has-error':'' ?>" ?>">
<?php echo "\t\t<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
		<div class="col-sm-10">
<?php if ($this->buildSetting->isDateColumn($column)): ?>
<?php if ($column->allowNull): ?>
<?php echo "\t\t\t<?php echo \$form->bsDateTextField(\$model,'{$column->name}', array('nullable'=>true)); ?>\n"; ?>
<?php else: ?>
<?php echo "\t\t\t<?php echo \$form->bsDateTextField(\$model,'{$column->name}', array('nullable'=>false)); ?>\n"; ?>
<?php endif; ?>
<?php echo "\t\t\t<?php echo \$form->bsError(\$model,'{$column->name}'); ?>\n"; ?>
<?php elseif ($this->buildSetting->isImageColumn($column)): ?>
		<div class="row">
			<div class="col-sm-2 text-left">
<?php echo "\t\t\t<?php echo Html::activeThumb(\$model, '{$column->name}'); ?>\n"; ?>
			</div>
			<div class="col-sm-8">
<?php echo "\t\t\t<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
<?php echo "\t\t\t<?php echo \$form->bsError(\$model,'{$column->name}'); ?>\n"; ?>
			</div>
		</div>
<?php elseif ($this->buildSetting->isFileColumn($column)): ?>
		<div class="row">
			<div class="col-sm-2 text-left">
			</div>
			<div class="col-sm-8">
<?php echo "\t\t\t<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
<?php echo "\t\t\t<?php echo \$form->bsError(\$model,'{$column->name}'); ?>\n"; ?>
			</div>
		</div>
<?php else: ?>
<?php echo "\t\t\t<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
<?php echo "\t\t\t<?php echo \$form->bsError(\$model,'{$column->name}'); ?>\n"; ?>
<?php endif; ?>
		</div>
	</div>
<?php else: ?>
	<?php $countLanguageField++; ?>
<?php endif; ?>
<?php endforeach; ?>


<?php if (!empty(Yii::app()->params['languages']) && $countLanguageField > 0): ?>
	<ul class="nav nav-tabs">
	<?php $counter = 0; foreach (Yii::app()->params['languages'] as $languageKey => $languageName): ?>
	<?php echo "\n\t<?php if(array_key_exists('{$languageKey}', Yii::app()->params['backendLanguages'])): ?>"; ?><li class="<?php if ($counter == 0) {
	echo 'active';
}?>"><a href="#pane-<?php echo $languageKey ?>" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo "<?php echo Yii::app()->params['backendLanguages']['{$languageKey}']; ?>" ?></a></li><?php echo '<?php endif; ?>'; ?>
	<?php $counter++; ?><?php endforeach; ?>
	
	</ul>
	<div class="tab-content">
	<?php $counter = 0; foreach (Yii::app()->params['languages'] as $languageKey => $languageName): ?>
		
		<!-- <?php echo $languageName ?> -->
		<?php echo "<?php if(array_key_exists('{$languageKey}', Yii::app()->params['backendLanguages'])): ?>\n"; ?>
		<div class="tab-pane <?php if ($counter == 0) {
	echo 'active';
}?>" id="pane-<?php echo $languageKey ?>">
<?php foreach ($this->tableSchema->columns as $column): ?>
<?php $languagePostfix = '_' . $languageKey; if (ysUtil::isLanguageField($column->name) && substr($column->name, -1 * (strlen($languagePostfix))) == $languagePostfix): ?>
<?php echo "\n\n"; ?>
			<div class="form-group <?php echo "<?php echo \$model->hasErrors('{$column->name}') ? 'has-error':'' ?>" ?>">
				<?php echo '<?php echo ' . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
				<div class="col-sm-10">
					<?php echo '<?php echo ' . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
					<?php echo "<?php echo \$form->bsError(\$model,'{$column->name}'); ?>\n"; ?>
				</div>
			</div>
<?php endif; ?><?php endforeach; ?>

		</div>
		<?php echo "<?php endif; ?>\n"; ?>
		<!-- /<?php echo $languageName ?> -->
		
<?php $counter++; ?>
<?php endforeach; ?>
	
	</div>
<?php endif; ?>

<?php $tags = $this->buildSetting->getTags(); ?>
<?php if (!empty($tags)): ?>
	<?php foreach ($tags as $tagKey => $tagValues): ?>
		
	<div class="form-group <?php echo "<?php echo \$model->hasErrors('tag_{$tagKey}') ? 'has-error':'' ?>" ?>">
		<?php echo "<?php echo \$form->bsLabelEx2(\$model, 'tag_{$tagKey}'); ?>\n" ?>
		<div class="col-sm-10">
			<?php echo "<?php echo \$form->bsTextField(\$model, 'tag_{$tagKey}', array('id'=>'{$this->getModelClass()}-tag_{$tagKey}', 'class'=>'form-control csv_tags')) ?>\n" ?>
			<?php echo "<?php echo \$form->bsError(\$model, 'tag_{$tagKey}') ?>\n" ?>
		</div>
	</div>
	<?php endforeach; ?>
<?php endif; ?>

		
	<!-- many2many -->
<?php if (!empty($many2many)): ?>
<?php foreach ($many2many as $m2mKey => $m2mValues): if ($m2mValues['notMasterData']) {
	continue;
} ?>

	<div class="form-group <?php echo sprintf("<?php echo \$model->hasErrors('input%s') ? 'has-error':'' ?>", ucwords($m2mValues['relationName'])) ?>">
		<?php echo sprintf("<?php echo \$form->bsLabelEx2(\$model,'input%s'); ?>\n", ucwords($m2mValues['relationName'])) ?>
		<div class="col-sm-10">
		<?php echo sprintf("\t<?php echo \$form->dropDownList(\$model, 'input%s', Html::listData(%s::getForeignReferList()), array('class'=>'chosen form-control', 'multiple'=>'multiple')); ?>\n", ucwords($m2mValues['relationName']), ucwords($m2mValues['className'])) ?>
		<?php echo sprintf("\t<?php echo \$form->bsError(\$model,'input%s'); ?>\n", ucwords($m2mValues['relationName'])) ?>
		</div>
	</div>
<?php endforeach; ?>
<?php endif; ?>
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo "<?php echo \$form->bsBtnSubmit(\$model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>\n"; ?>
		</div>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->

<?php if (!empty($spatials)): ?><?php foreach ($spatials as $spatial): ?>
<?php echo sprintf("<?php Yii::app()->clientScript->registerScript('google-map', '
\n\t$(document).on(\"change\", \"%s\", function(){update%s%s2LatLong();});\n'); ?>\n", $this->buildSetting->getSpatialOnChange($this->getModelClass(), $spatial), $this->getModelClass(), ltrim($this->buildSetting->camelizeColumnName($spatial), 'latlong_')) ?>
<?php endforeach; ?><?php endif; ?>