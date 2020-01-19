<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/


class WebApplication extends CWebApplication
{
    public function createController($route,$owner=null)
	{
		if($owner===null)
			$owner=$this;
		if((array)$route===$route || ($route=trim($route,'/'))==='')
			$route=$owner->defaultController;
		$caseSensitive=$this->getUrlManager()->caseSensitive;
		$route.='/';
		while(($pos=strpos($route,'/'))!==false)
		{
			$id=substr($route,0,$pos);
			if(!preg_match('/^\w+$/',$id))
				return null;
			if(!$caseSensitive)
				$id=strtolower($id);
            $route=(string)substr($route,$pos+1);
			if(!isset($basePath))  // first segment
			{
				if(isset($owner->controllerMap[$id]))
				{
					return array(
						Yii::createComponent($owner->controllerMap[$id],$id,$owner===$this?null:$owner),
						$this->parseActionParams($route),
					);
				}
				if(($module=$owner->getModule($id))!==null)
                    return $this->createController($route,$module);
                $basePath=$owner->getControllerPath();
				
				$controllerID='';
			}
			else
				$controllerID.='/';
			$className=ucfirst($id).'Controller';
            $classFile=$basePath.DIRECTORY_SEPARATOR.$className.'.php';
            
            // exiang: modification start:
            // check is override controller files exists, if yes, use it instead
            $overrideClassFile = Yii::getPathOfAlias('overrides').DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$className.'.php';
            if(file_exists($overrideClassFile))
            {
                $classFile = $overrideClassFile;
                $basePath = Yii::getPathOfAlias('overrides') . DIRECTORY_SEPARATOR . 'controllers';
                
                // should we override the view? 
                // if yes, user will need to duplicate entire view directory contents to override/views
                // if no, user will needs to use $this->render('application.overrides.views.site.about'); when rendering views
				$this->setViewPath(Yii::getPathOfAlias('overrides') . DIRECTORY_SEPARATOR . 'views');
			}
			
			// override layouts
			// if custom layouts found at override folder, system will swtich the base layout path to it
			$overrideLayoutDirectory = Yii::getPathOfAlias('overrides').DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'layouts';
            if(is_dir($overrideLayoutDirectory))
            {
				$this->setLayoutPath($overrideLayoutDirectory);
			}
			
			Yii::setPathOfAlias('layouts', $this->getLayoutPath());
            // exiang: modification end

            if($owner->controllerNamespace!==null)
				$className=$owner->controllerNamespace.'\\'.str_replace('/','\\',$controllerID).$className;
			if(is_file($classFile))
			{
				if(!class_exists($className,false))
					require($classFile);
				if(class_exists($className,false) && is_subclass_of($className,'CController'))
				{
					$id[0]=strtolower($id[0]);
					return array(
						new $className($controllerID.$id,$owner===$this?null:$owner),
						$this->parseActionParams($route),
					);
				}
				return null;
			}
			$controllerID.=$id;
            $basePath.=DIRECTORY_SEPARATOR.$id;
            
                
		}
	}
}