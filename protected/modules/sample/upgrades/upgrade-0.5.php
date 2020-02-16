<?php

function upgrade_module_0_5($about)
{
    Setting::setSetting('sample-var1', 'Hello World 0.5', 'string');
    return "Upgrade to version 0.5\n";
}
