<?php

class Page extends PageBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function init()
	{
		parent::init();
		$this->is_default = 0;
	}
	
	public function getBySlug($slug)
	{
		$model = $this->find('t.slug=:slug', array(':slug'=>$slug));
		if($model===null)
			throw new CHttpException(404,'The requested content does not exist.');
		return $model;
	}
}
