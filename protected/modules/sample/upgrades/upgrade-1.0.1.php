<?php

function upgrade_module_1_0_1($about)
{
	Setting::setSetting('sample-var1', 'Hello World 1.0.1', 'string');

	return "Upgrade to version 1.0.1\n";
}
