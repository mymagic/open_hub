<?php
/* @var $this Resource2OrganizationFundingController */
/* @var $model Resource2OrganizationFunding */

$this->breadcrumbs=array(
	Yii::t('backend', 'Resource2 Organization Fundings')=>array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Create Resource2OrganizationFunding'), 'url'=>array('/resource2OrganizationFunding/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#resource2-organization-funding-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Resource2 Organization Fundings'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-resource2OrganizationFundingSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-resource2OrganizationFundingSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id'=>'resource2-organization-funding-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
		array('name'=>'resource_id', 'cssClassExpression'=>'foreignKey', 'value'=>'$data->resource->title', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>Resource::model()->getForeignReferList(false, true)),
		array('name'=>'organization_funding_id', 'cssClassExpression'=>'foreignKey', 'value'=>'$data->organizationFunding->id', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>OrganizationFunding::model()->getForeignReferList(false, true)),
		array('name'=>'as_role_code', 'cssClassExpression'=>'foreignKey', 'value'=>'$data->->', 'headerHtmlOptions'=>array('class'=>'foreignKey'), 'filter'=>::model()->getForeignReferList(false, true)),

		array(
			'class'=>'application.components.widgets.ButtonColumn',
					),
	),
)); ?>
