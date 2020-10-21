<?php

$this->widget('application.components.widgets.ListView', array(
	'id' => 'user2Emails',
	'dataProvider' => $list['dataProvider'],
	'itemView' => '_list-getUser2Emails',
	'viewData' => array('realm' => $realm),
	'ajaxUpdate' => true,
	'enablePagination' => true,
	'pagerCssClass' => 'pagination-dark',
	'sortableAttributes' => array(
		'date_added',
	),
));
