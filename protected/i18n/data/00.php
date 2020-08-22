<?php
/**
 * Extends Locale data for 'en_US'.
 * In this file you can put custom locale settings that will be
 * merged with the ones provided by the framework
 * ( that are stored in <framework_dir>/i18n/data/ )
 */

return CMap::mergeArray(
	require(Yii::getPathOfAlias('system.i18n.data') . DIRECTORY_SEPARATOR . basename(__FILE__)),
	array(
		// http://www.unicode.org/reports/tr35/tr35-dates.html#Date_Field_Symbol_Table
		'dateFormats' => array(
			'standard' => 'y LLL dd',
			'rfc' => 'EEE, dd LLL y',
		),
		'timeFormats' => array(
			'standard' => 'kk:mm a',
			'rfc' => 'kk:mm:ss',
		),
	)
);
