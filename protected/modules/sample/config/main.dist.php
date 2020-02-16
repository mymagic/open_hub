<?php

return array(
    'import' => array(
        'application.modules.sample.models.*',
    ),

    'modules' => array(
        'sample' => array(
            'var1' => '',
            'var2' => '',
            'modelBehaviors' => array(
                'Organization' => array(
                    'class' => 'application.modules.sample.components.SampleOrganizationBehavior',
                ),
                /*'Individual'=>array(
                    'class'=>'application.modules.boilerplateStart.components.BoilerplateStartIndividualBehavior',
                ),
                'Event'=>array(
                    'class'=>'application.modules.boilerplateStart.components.BoilerplateStartEventBehavior',
                ),
                'Resource'=>array(
                    'class'=>'application.modules.boilerplateStart.components.BoilerplateStartResourceBehavior',
                ),*/
            ),
        ),
    ),

    'components' => array(
        'request' => array(
            'noValidationRegex' => array(
            ),
        ),

        'urlManager' => array(
            'rules' => array(
                '<language:(ms|en|zh)>/sampleGroup' => 'sample/sampleGroup',
                '<language:(ms|en|zh)>/sampleZone' => 'sampleZone',
                '<language:(ms|en|zh)>/sample' => 'sample/sample',
            ),
        ),
    ),
);
