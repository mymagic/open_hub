<?php
class EmailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/backend';

	public function actions()
	{
		return array
		(
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','admin'),
				'users'=>array('@'),
				'expression'=>"\$user->isEmailManager==true && \$user->accessBackend==true",
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$this->redirect('admin');
	}
	
	public function actionAdmin()
	{
		$this->render('admin');
	}
}
