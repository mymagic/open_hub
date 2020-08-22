<?php

return array(
	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
				'f7/form/import*',
			),
		),
		'urlManager' => array(
			'rules' => array(
				//
				// f7
				//'f7/publish/download/<downloadFile>' => 'f7/publish/download',
				'f7/publish/<slug>' => 'f7/publish/index',
				'f7/publish/<action:(index|view|edit|save|revert|revertConfirmed)>/<slug>' => 'f7/publish/<action>',
				'f7/publish/<action:(index|view|edit|save|revert|revertConfirmed)>/<slug>/<sid>' => 'f7/publish/<action>',
				'f7/publish/<action:(index|view|edit|save|revert|revertConfirmed)>/<slug>/<sid>/<eid>' => 'f7/publish/<action>',
			),
		),
	),
);
