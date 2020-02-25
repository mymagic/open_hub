<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs = array(
	'Charges' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Charge'), 'url' => array('/charge/admin')),
	array('label' => Yii::t('app', 'Create Charge'), 'url' => array('/charge/create')),
	array('label' => Yii::t('app', 'Update Charge'), 'url' => array('/charge/update', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'View Charge'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		//'id',
		'code',
		'title',
		array('name' => 'amount', 'value' => Html::formatMoney($model->amount, $model->currency_code)),
		array('name' => 'text_description', 'type' => 'raw', 'value' => nl2br($model->text_description)),
		array('label' => $model->attributeLabel('date_started'), 'value' => Html::formatDateTime($model->date_started, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_expired'), 'value' => Html::formatDateTime($model->date_expired, 'long', 'medium')),
		array('name' => 'status', 'value' => $model->formatEnumStatus($model->status)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('name' => 'charge_to', 'value' => $model->formatEnumChargeTo($model->charge_to)),
		array('name' => 'charge_to_code', 'value' => $model->charge_to_code),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>


<h2>Transactions</h2>
<p>All transactions from user will be listed below.</p>
<!-- Transactions -->
<div class="table-responsive"><table class="table table-bordered">
	<thead><tr>
		<th>Transaction Id</th>
		<th>Date</th>
		<th>Detail</th>
		<th class="text-right">Amount</th>
		<th class="text-center">Status</th>
	</tr></thead>
	<tbody>
	
	<?php foreach ($model->transactions as $tx): ?>
	<tr>
		<td><?php echo $tx->txnid ?></td>
		<td><?php echo Html::formatDateTime($tx->date_added) ?></td>
		<td><?php echo $tx->vendor ?></td>
		<td class="text-right "><?php echo Html::formatMoney($tx->amount, $tx->currency_code) ?></td>
		<td class="text-center"><span class="label"><?php echo $tx->status ?></span></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table></div>
<!-- /Transactions -->