<?php

function upgrade_module_0_2($about)
{
    Setting::setSetting('sample-var1', 'Hello World 0.2', 'string');
    return "Upgrade to version 0.2\n";
}
