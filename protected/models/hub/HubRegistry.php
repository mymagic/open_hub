<?php

class HubRegistry
{
    public static function get($code)
    {
        $model=Registry::model()->code2obj($code);
		if($model===null)
			throw new CHttpException(404,'The requested registry does not exist.');
		return $model;
    }

    public static function set($code, $value)
	{
        if(Registry::isCodeExists($code))
        {
            $registry = self::get($code);
        }
        else
        {
            $registry = new Registry;
        }

        $registry->code = $code;
        $registry->the_value = $value;
        return $registry->save();
    }
}