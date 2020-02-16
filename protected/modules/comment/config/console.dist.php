<?php

return array(
    'import' => array(
        'application.modules.comment.models.*',
    ),

    'modules' => array(
        'comment' => array(
            'abc'=>'123',
            'modelBehaviors'=>array(
                'Organization'=>array(
                    'class'=>'application.modules.comment.components.CommentOrganizationBehavior',
                ),
                'Individual'=>array(
                    'class'=>'application.modules.comment.components.CommentIndividualBehavior',
                ),
                'Event'=>array(
                    'class'=>'application.modules.comment.components.CommentEventBehavior',
                ),
                'Resource'=>array(
                    'class'=>'application.modules.comment.components.CommentResourceBehavior',
                ),
            )
        ),
    ),

    'components' => array(
        'request' => array(
            'noValidationRegex' => array(
                'comment/api/*',
            ),
        ),
        
        'urlManager' => array(
            'rules' => array(
                
            ),
        ),
    ),
);