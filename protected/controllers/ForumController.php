<?php

class ForumController extends Controller
{
	public $layout='//layouts/cpanel';
/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'
				),
				'users'=>array('@'),
				'expression'=>"\$user->accessCpanel===true",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function init()
	{
		$this->activeMenuMain = 'forum';
		parent::init();
	}
	
	public function actionIndex()
	{
		$this->activeSubMenuCpanel = 'qa';
		$this->render('index');
	}
}