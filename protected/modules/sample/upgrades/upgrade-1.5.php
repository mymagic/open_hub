<?php

function upgrade_module_1_5($about)
{
	Setting::setSetting('sample-var1', 'Hello World 1.5', 'string');

	return "Upgrade to version 1.5\n";
}
