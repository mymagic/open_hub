<?php

class WebModule extends CWebModule
{
    public $modelBehaviors;
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(Yii::app()->params['dev'] == true)
			{
				Yii::app()->assetManager->forceCopy = true;
			}
			
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function setupSetting($code, $value, $extra=null)
	{
		// setting exists, dont change value
		if(Setting::isCodeExists($code))
		{
			return true;
		}
		else
		{
			// setting not exists, create one
			$setting = new Setting;
			$setting->code = $code;
			$setting->value = $value;
			$setting->datatype = (!empty($extra) && !empty($extra['datatype']))?$extra['datatype']:'string';
			$setting->datatype_value = (!empty($extra) && !empty($extra['datatype_value']))?$extra['datatype_value']:'';
			$setting->note = (!empty($extra) && !empty($extra['note']))?$extra['note']:'';
			return $setting->save();
		}
	}

}