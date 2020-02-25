<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs = array(
	Yii::t('backend', 'Charges') => array('index'),
	Yii::t('backend', 'Manage'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Create Charge'), 'url' => array('/charge/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#charge-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('backend', 'Manage Charges'); ?></h1>


<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse-chargeSearch"><i class="fa fa-search"></i>&nbsp; Advanced Search</a></h4>
</div>
<div id="collapse-chargeSearch" class="panel-collapse collapse">
	<div class="panel-body search-form">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
	</div>
</div>
</div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'charge-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'id', 'cssClassExpression' => 'id', 'value' => $data->id, 'headerHtmlOptions' => array('class' => 'id')),
		array('name' => 'charge_to_code', 'type' => 'raw', 'value' => 'sprintf(\'%s - %s\', $data->formatEnumChargeTo($data->charge_to), $data->charge_to_code)'),
		'title',
		array('name' => 'amount', 'type' => 'raw', 'value' => 'Html::formatMoney($data->amount, $data->currency_code)', 'filter' => false),
		array('name' => 'date_expired', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_expired, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
		array('name' => 'status', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumStatus($data->status)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumStatus(false, true)),
		array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array('delete' => array('visible' => false)),		),
	),
)); ?>
