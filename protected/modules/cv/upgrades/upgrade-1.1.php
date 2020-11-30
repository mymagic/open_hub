<?php

function upgrade_module_1_1($about)
{
	$migration = Yii::app()->db->createCommand();

	$result = Service::setService('cv', 'CV Portfolio', 'A talent directory showcasing  experience and qualifications for job opportunity and cofounder matching', array('is_bookmarkable' => 1, 'is_active' => 1));

	if ($result) {
		return "Upgraded to version 1.1\n";
	} else {
		return "Failed to upgrade to version 1.1 due to unable to set service record\n";
	}
}
