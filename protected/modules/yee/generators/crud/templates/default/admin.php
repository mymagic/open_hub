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
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('backend', '$label')=>array('index'),
	Yii::t('backend', 'Manage'),
);\n";
?>

<?php echo ($this->buildSetting->getMenu('admin', $this)); ?>

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php $tmp = $this->pluralize($this->class2name($this->modelClass)); echo "<?php echo Yii::t('backend', 'Manage {$tmp}'); ?>" ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo lcfirst($this->modelClass) ?>Search"><i class="fa fa-search"></i>&nbsp; <?php echo Yii::t('core', 'Advanced Search') ?></a></h4>
</div>
<div id="collapse-<?php echo lcfirst($this->modelClass) ?>Search" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php echo "<?php \$this->renderPartial('_search',array(
		'model'=>\$model,
	)); ?>\n"; ?>
	</div>
</div>
</div>

<?php echo "<?php"; ?> $this->widget('application.components.widgets.GridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php

$columns =  $this->tableSchema->columns;
$finalColumns = array();

$buildArray = $this->buildSetting->getBuildArray();
$adminList = $buildArray['admin']['list'];
if(!empty($adminList))
{
	foreach($adminList as $adminItem)
	{
		foreach($columns as $k=>$c)
		{
			if($adminItem == $c->name)
			{
				$finalColumns[]  = $columns[$k];
				continue;
			}
		}
		
	}
}

// if no predefined admin list setting found
if(empty($finalColumns))
{
	$finalColumns = $columns;
}

$count=0;
foreach($finalColumns as $column)
{
	// id
	if($this->buildSetting->isIdColumn($column))
	{
		echo "\t\tarray('name'=>'id', 'cssClassExpression'=>'id', 'value'=>\$data->id, 'headerHtmlOptions'=>array('class'=>'id')),\n";
	}
	// foreign
	elseif($this->buildSetting->isForeignKeyColumn($column->name))
	{
		$relationName = $this->buildSetting->getForeignKeyRelationName($column->name);
		$foreignModel = $this->buildSetting->getForeignKeyModelName($column->name);
		$foreignReferAttribute = $this->buildSetting->getForeignKeyReferAttribute($column->name);
		
		if($this->buildSetting->isLanguageColumn($foreignReferAttribute))
		{
			$value = sprintf("\$data->getAttributeDataByLanguage(\$data->{$relationName}, \"%s\")", $this->buildSetting->removeLanguagePostfix($foreignReferAttribute));
		}
		else
		{
			$value = "\$data->{$relationName}->{$foreignReferAttribute}";
		}
		echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'foreignKey', 'value'=>'{$value}', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>{$foreignModel}::model()->getForeignReferList(false, true)),\n";
	}
	// enum
	elseif($this->buildSetting->isEnumColumn($column))
	{
		$enumFunctionName = $this->buildSetting->figureEnumFunctionName($column->name);
		echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'enum', 'value'=>'\$data->formatEnum{$enumFunctionName}(\$data->{$column->name})', 'headerHtmlOptions'=>array('class'=>'enum'), 'filter'=>\$model->getEnum{$enumFunctionName}(false, true)), \n";
	}
	// boolean
	elseif($this->buildSetting->isBooleanColumn($column))
	{
		// echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'boolean', 'value'=>'Yii::t(\'core\', Yii::app()->format->boolean(\$data->{$column->name}))', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>\$model->getEnumBoolean()), \n";
		echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'boolean', 'type'=>'raw', 'value'=>'Html::renderBoolean(\$data->{$column->name})', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>\$model->getEnumBoolean()), \n";
	}
	// date
	elseif($this->buildSetting->isDateColumn($column))
	{
		echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime(\$data->{$column->name}, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),\n";
	}
	// html
	elseif($this->buildSetting->isHtmlColumn($column))
	{
		// dont display
	}
	// image
	elseif($this->buildSetting->isImageColumn($column))
	{
		// dont display
		echo "\t\tarray('name'=>'{$column->name}', 'cssClassExpression'=>'image', 'type'=>'raw', 'value'=>'Html::activeThumb(\$data, \'{$column->name}\')', 'headerHtmlOptions'=>array('class'=>'image'), 'filter'=>false),\n";
	}
	// text
	elseif($this->buildSetting->isTextColumn($column))
	{
		// dont display
	}
	// ordering
	elseif($this->buildSetting->isOrderingColumn($column))
	{
		echo "\t\tarray('name'=>'{$column->name}', 'headerHtmlOptions'=>array('class'=>'ordering'), 'class'=>'application.yeebase.extensions.OrderColumn.OrderColumn'),\n";
	}
	// normal
	else
	{
		echo "\t\t'".$column->name."',\n";
	}
}
echo "\n";
?>
		array(
			'class'=>'application.components.widgets.ButtonColumn',
			<?php if($this->buildSetting->isDeleteDisabled()): ?>'buttons' => array('delete' => array('visible'=>false)),<?php endif; ?>
		),
	),
)); ?>
