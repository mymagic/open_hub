<?php
class ApplicationConfigBehavior extends CBehavior
{

    public function events()
    {
        return array_merge(parent::events(),array(
            'onBeginRequest'=>'beginRequest',
        ));
    }

    public function beginRequest()
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
		// here is abit hardcode but cant find better way to do it
        if ($uri[3] == 'backend' || $uri[2] == 'backend' || $uri[1] == 'backend')
            Yii::app()->user->loginUrl = Yii::app()->createUrl('/backend/login');
    }
}
