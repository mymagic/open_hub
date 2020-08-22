<?php

class BoilerplateStartController extends Controller
{
	public function init()
	{
		parent::init();
		$this->layout = 'frontend';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
	}

	public function actionIndex()
	{
		echo 'yo';
		Yii::app()->end();
	}
}
