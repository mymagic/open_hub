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
/* @var $data <?php echo $this->getModelClass(); ?> */
?>

<div class="view panel panel-default">
<div class="panel-heading">
<?php
	echo "\t<b><?php echo Html::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
	echo "\t#<?php echo Html::link(Html::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
?>
</div>
<div class="panel-body">

<?php
$count=0;
$languageColumnBins = array();
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
		continue;
		
	// language detection
	$isLanguageColumn = $this->buildSetting->isLanguageColumn($column->name);
	$languageColumnName = $this->buildSetting->removeLanguagePostfix($column->name);
	if(!in_array($languageColumnName, $languageColumnBins))
	{
		$languageColumnBins[] = $languageColumnName;
	}
	else
	{
		// skip
		continue;
	}
	
	if($isLanguageColumn)
	{
		echo "\t<b><?php echo Html::encode(\$data->getAttributeLabelByLanguage(\$data, '{$languageColumnName}')); ?>:</b>\n";
	}
	else
	{
		echo "\t<b><?php echo Html::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
	}
	
	// foreign
	if($this->buildSetting->isForeignKeyColumn($column->name))
	{
		$relationName = $this->buildSetting->getForeignKeyRelationName($column->name);
		$foreignModel = $this->buildSetting->getForeignKeyModelName($column->name);
		$foreignReferAttribute = $this->buildSetting->getForeignKeyReferAttribute($column->name);
		
		if($this->buildSetting->isLanguageColumn($foreignReferAttribute))
		{
			echo sprintf("\t<?php echo Html::encode(\$data->getAttributeDataByLanguage(\$data->{$relationName}, \"%s\")); ?>\n\t<br />\n\n", $this->buildSetting->removeLanguagePostfix($foreignReferAttribute));
		}
		else
		{
			echo "\t<?php echo Html::encode(\$data->{$relationName}->{$foreignReferAttribute}); ?>\n\t<br />\n\n";
		}
		
	}
	// json
	elseif($this->buildSetting->isJsonColumn($column))
	{
	}
	// enum
	elseif($this->buildSetting->isEnumColumn($column))
	{
		$enumFunctionName = $this->buildSetting->figureEnumFunctionName($column->name);
		echo "\t<?php echo Html::encode(\$data->formatEnum{$enumFunctionName}(\$data->{$column->name})); ?>\n\t<br />\n\n";
	}
	// boolean
	elseif($this->buildSetting->isBooleanColumn($column))
	{
		echo "\t<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean(\$data->{$column->name}))); ?>\n\t<br />\n\n";
	}
	// date
	elseif($this->buildSetting->isDateColumn($column))
	{
		echo "\t<?php echo Html::encode(Html::formatDateTime(\$data->{$column->name}, 'long', 'medium')); ?>\n\t<br />\n\n";
	}
	// imag
	elseif($this->buildSetting->isImageColumn($column))
	{
		echo "\t<?php echo Html::activeThumb(\$data, '{$column->name}'); ?><br />\n\n";
	}
	// html
	elseif($this->buildSetting->isHtmlColumn($column))
	{
		// is language field
		if($isLanguageColumn)
		{			
			echo "\t<?php echo (\$data->getAttributeDataByLanguage(\$data, '{$languageColumnName}')); ?>\n\t<br />\n\n";
		}
		else
		{
			echo "\t<?php echo (\$data->{$column->name}); ?>\n\t<br />\n\n";
		}
	}
	else
	{
		// is language field
		if($isLanguageColumn)
		{			
			echo "\t<?php echo Html::encode(\$data->getAttributeDataByLanguage(\$data, '{$languageColumnName}')); ?>\n\t<br />\n\n";
		}
		else
		{
			echo "\t<?php echo Html::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
		}
	}
}

?>

</div>
</div>