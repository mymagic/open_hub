<?php

return array(
	'components' => array(
		'urlManager' => array(
			'rules' => array(
				//
				// f7
				'f7/publish/download/<downloadFile>' => 'f7/publish/download',
				'f7/publish/<slug>' => 'f7/publish/index',
				'f7/publish/<action:(index|view|edit|save|confirm)>/<slug>/<sid>/<eid>' => 'f7/publish/<action>',
				'f7/publish/<action:(index|view|edit|save|confirm)>/<slug>/<sid>' => 'f7/publish/<action>',
				'f7/publish/<action:(index|view|edit|save|confirm)>/<slug>' => 'f7/publish/<action>',
			),
		),
	)
);
