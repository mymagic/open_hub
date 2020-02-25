<?php

function upgrade_module_1_1_0($about)
{
	Setting::setSetting('sample-var1', 'Hello World 1.1.0', 'string');

	return "Upgrade to version 1.1.0\n";
}
