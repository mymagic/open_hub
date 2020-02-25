<?php
$this->breadcrumbs = array(
	'Charge' => array('charge/list'),
);?>

<?php $this->renderPartial('/cpanel/_menu', array('model' => $model, )); ?>

<?php $this->widget('application.components.widgets.ListView', array(
	'id' => 'cpanelCharges',
	'dataProvider' => $dataProvider,
	'viewData' => array('chargeToCode' => $chargeToCode),
	'itemView' => '_list-getCharges',
	'ajaxUpdate' => true,
	'enablePagination' => true,
	'pagerCssClass' => 'pagination-dark',
	/*'sortableAttributes'=>array(
		'date_added'=>Yii::t('default', 'Date'),
		'title',
	),*/
)); ?>
