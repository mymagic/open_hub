<?php

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Resources'), 'url' => array('/resource/resource/admin')),
	array('label' => Yii::t('app', 'Create Resource'), 'url' => array('/resource/resource/create')),

	array('label' => Yii::t('app', 'Manage Award'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'award')),
	array('label' => Yii::t('app', 'Manage Funding'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'fund')),
	array('label' => Yii::t('app', 'Manage Legislation'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'legislation')),
	array('label' => Yii::t('app', 'Manage Media'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'media')),
	array('label' => Yii::t('app', 'Manage Program'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'program')),
	array('label' => Yii::t('app', 'Manage Space'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'space')),
	array('label' => Yii::t('app', 'Manage Others'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'other')),
);
