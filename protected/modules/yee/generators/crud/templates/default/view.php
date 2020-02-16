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

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

<?php echo ($this->buildSetting->getMenu('view', $this)); ?>
?>

<?php $many2many = $this->buildSetting->getMany2Many() ?>
<?php if(!empty($many2many)): ?>
<?php foreach($many2many as $m2mKey=>$m2mValues): ?>

<?php echo sprintf("\n<?php foreach(\$model->%s as \$%s): ?>\n", $m2mValues['relationName'], $this->buildSetting->camelizeColumnName($m2mKey)); ?>
<?php echo sprintf("\t<?php \$input%s .= sprintf('<span class=\"label\">%%s</span>&nbsp;', \$%s->title) ?>\n", ucwords($m2mValues['relationName']), $this->buildSetting->camelizeColumnName($m2mKey)); ?>
<?php echo sprintf("<?php endforeach; ?>\n"); ?>
<?php endforeach; ?>
<?php endif; ?>

<h1><?php $tmp = ($this->class2name($this->modelClass)); echo "<?php echo Yii::t('backend', 'View {$tmp}'); ?>" ?></h1>

<div class="crud-view">
<?php echo "<?php"; ?> $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
$countLanguageField = 0;
foreach($this->tableSchema->columns as $column)
{
	if(!ysUtil::isLanguageField($column->name))
	{
		// foreign
		if($this->buildSetting->isForeignKeyColumn($column->name))
		{
			$relationName = $this->buildSetting->getForeignKeyRelationName($column->name);
			$foreignModel = $this->buildSetting->getForeignKeyModelName($column->name);
			$foreignReferAttribute = $this->buildSetting->getForeignKeyReferAttribute($column->name);
			
			if($this->buildSetting->isLanguageColumn($foreignReferAttribute))
			{
				$value = sprintf("\$model->getAttributeDataByLanguage(\$model->{$relationName}, \"%s\")", $this->buildSetting->removeLanguagePostfix($foreignReferAttribute));
			}
			else
			{
				$value = "\$model->{$relationName}->{$foreignReferAttribute}";
			}
			
			echo "\t\tarray('name'=>'{$column->name}', 'value'=>{$value}),\n";
		}
		// csv
		elseif($this->buildSetting->isCsvColumn($column))
		{
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>\Html::csvArea('{$column->name}', \$model->{$column->name})),\n";
		}
		// enum
		elseif($this->buildSetting->isEnumColumn($column))
		{
			$enumFunctionName = $this->buildSetting->figureEnumFunctionName($column->name);
			echo "\t\tarray('name'=>'{$column->name}', 'value'=>\$model->formatEnum{$enumFunctionName}(\$model->{$column->name})),\n";
		}
		// boolean
		elseif($this->buildSetting->isBooleanColumn($column))
		{
			//echo "\t\tarray('name'=>'{$column->name}',  'value'=>Yii::t('core', Yii::app()->format->boolean(\$model->{$column->name}))), \n";
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>Html::renderBoolean(\$model->{$column->name})), \n";
		}
		// date
		elseif($this->buildSetting->isDateColumn($column))
		{
			echo "\t\tarray('label'=>\$model->attributeLabel('{$column->name}'), 'value'=>Html::formatDateTime(\$model->{$column->name}, 'long', 'medium')),\n";
		}
		// html
		elseif($this->buildSetting->isHtmlColumn($column))
		{
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>\$model->{$column->name}),\n";
		}
		// image
		elseif($this->buildSetting->isImageColumn($column))
		{
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>Html::activeThumb(\$model, '{$column->name}')),\n";
		}
		// file
		elseif($this->buildSetting->isFileColumn($column))
		{
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>Html::activeFile(\$model, '{$column->name}')),\n";
		}
		// text
		elseif($this->buildSetting->isTextColumn($column))
		{
			echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>nl2br(\$model->{$column->name})),\n";
		}
		// json
		else if($this->buildSetting->isJsonColumn($column))
		{
		}
		// spatial
		else if($this->buildSetting->isSpatialColumn($column))
		{
		}
		// normal
		else
		{
			echo "\t\t'".$column->name."',\n";
		}
	}
	else
	{
		$countLanguageField++;
	}
}

if(!empty($many2many))
{
	echo "\n";
	foreach($many2many as $m2mKey=>$m2mValues)
	{
		echo sprintf("\t\tarray('name'=>'input%s', 'type'=>'raw', 'value'=>\$input%s),\n", ucwords($m2mValues['relationName']), ucwords($m2mValues['relationName']));
	}
}
?>
<?php 
$tags = $this->buildSetting->getTags();
if(!empty($tags))
{
	foreach($tags as $tagKey=>$tagValues) 
	{
		echo "\t\tarray('name'=>'{$tagKey}', 'type'=>'raw', 'value'=>Html::csvArea('{$tagKey}', \$model->{$tagKey}->toString())),\n";
	}
}
?>
	),
)); ?>

<?php 
$spatials = $this->buildSetting->getSpatialColumns();

if(!empty($spatials)): ?><?php foreach($spatials as $spatial): ?>
<h3><?php echo sprintf("<?php echo \$model->getAttributeLabel('%s') ?>", $spatial) ?></h3>
<?php echo sprintf("<?php echo Html::mapView('map-resourceAddress', \$model->%s[0], \$model->%s[1]) ?>", $spatial, $spatial) ?>
<?php endforeach; ?><?php endif; ?>


<?php if(!empty(Yii::app()->params['languages']) && $countLanguageField>0): ?>

<ul class="nav nav-tabs">
	<?php $counter=0; foreach(Yii::app()->params['languages'] as $languageKey => $languageName): ?>
	<?php echo "\n\t<?php if(array_key_exists('{$languageKey}', Yii::app()->params['backendLanguages'])): ?>"; ?><li class="<?php if($counter==0){echo "active"; }?>"><a href="#pane-<?php echo $languageKey ?>" data-toggle="tab"><?php echo "<?php echo Yii::app()->params['backendLanguages']['{$languageKey}']; ?>" ?></a></li><?php echo "<?php endif; ?>"; ?>
	<?php $counter++; ?><?php endforeach; ?>
	
</ul>
<div class="tab-content">
<?php $counter=0; foreach(Yii::app()->params['languages'] as $languageKey => $languageName): ?>
	
	<!-- <?php echo $languageName ?> -->
	<?php echo "<?php if(array_key_exists('{$languageKey}', Yii::app()->params['backendLanguages'])): ?>\n"; ?>
	<div class="tab-pane <?php if($counter==0){echo "active"; }?>" id="pane-<?php echo $languageKey ?>">

	<?php echo "<?php"; ?> $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
	<?php foreach($this->tableSchema->columns as $column)
	{
		// fore language
		$languagePostfix="_".$languageKey; 
		if(ysUtil::isLanguageField($column->name) && ysUtil::isLanguageField($column->name) && substr($column->name, -1*(strlen($languagePostfix)))==$languagePostfix)
		{
			// html
			if($this->buildSetting->isHtmlColumn($column))
			{
				echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>\$model->{$column->name}),\n";
			}
			// text
			elseif($this->buildSetting->isTextColumn($column))
			{
				echo "\t\tarray('name'=>'{$column->name}', 'type'=>'raw', 'value'=>nl2br(\$model->{$column->name})),\n";
			}
			// normal
			else
			{
				echo "\t\t'".$column->name."',\n";
			}
		}
	}?>
	),
)); ?>
	
	</div>
	<?php echo "<?php endif; ?>\n"; ?>
	<!-- /<?php echo $languageName ?> -->
	<?php $counter++; ?>
	
<?php endforeach; ?>

</div>
<?php endif; ?>
</div>