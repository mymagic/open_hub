<?php

$this->widget('application.components.widgets.ListView', array(
	'id' => 'individual2Emails',
	'dataProvider' => $list[dataProvider],
	'itemView' => '_list-getIndividual2Emails',
	'viewData' => array('realm' => $realm),
	'ajaxUpdate' => true,
	'enablePagination' => true,
	'pagerCssClass' => 'pagination-dark',
	'sortableAttributes' => array(
		'date_added',
	),
));
