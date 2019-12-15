<?php
class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout='//layouts/backend';

	public function actions()
	{
		return array
		(
 		);
	}
	
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('list','view','create','update','admin','adminByOrganization' ),
				'users'=>array('@'),
				'expression'=>"\$user->isAdmin==true",
			),
			array('allow',
				'actions'=>array('view','create','update','adminByOrganization'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function init()
	{
		$this->activeMenuCpanel = 'organization';
		$this->activeMenuMain = 'organization';
		parent::init();
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm='backend')
	{
		if(empty($realm)) $realm='backend';
		if($realm == 'cpanel') $this->layout='//layouts/cpanel';
		$this->pageTitle = Yii::t('app', 'View Product');
		$this->activeSubMenuCpanel = 'product-adminByOrganization';

		$product = $this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$product, 
			'organization'=>$product->organization, 
			'realm'=>$realm
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($organization_id='', $realm='backend')
	{
		if(empty($realm)) $realm='backend';
		if($realm == 'cpanel') $this->layout='//layouts/cpanel';
		$this->pageTitle = Yii::t('app', 'Create Product');
		$this->activeSubMenuCpanel = 'product-create';

		$model=new Product;
		if(!empty($organization_id)) $model->organization_id = $organization_id;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');
	
			if($model->save())
			{
				UploadManager::storeImage($model, 'cover', $model->tableName());
				$this->redirect(array('view','id'=>$model->id, 'realm'=>$realm));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'organization'=>$model->organization,
			'realm'=>$realm
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $realm='backend')
	{
		if(empty($realm)) $realm='backend';
		if($realm == 'cpanel') $this->layout='//layouts/cpanel';
		$this->pageTitle = Yii::t('app', 'Update Product');
		$this->activeSubMenuCpanel = 'product-adminByOrganization';

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');

			if($model->save())
			{
				UploadManager::storeImage($model, 'cover', $model->tableName());
				$this->redirect(array('view','id'=>$model->id, 'realm'=>$realm));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'organization'=>$model->organization,
			'realm'=>$realm
		));
	}

	
	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('product/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('Product');
				$dataProvider->pagination->pageSize = 5;
		$dataProvider->pagination->pageVar = 'page';
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product'])) $model->attributes=$_GET['Product'];
		if(Yii::app()->request->getParam('clearFilters')) EButtonColumnWithClearFilters::clearFilters($this,$model);

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAdminByOrganization($organization_id, $realm='backend')
	{
		if(empty($realm)) $realm='backend';
		if($realm == 'cpanel') $this->layout='//layouts/cpanel';
		$this->pageTitle = Yii::t('app', 'Manage Products');

		//$this->activeSub = 'product-adminByOrganization';
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product'])) $model->attributes=$_GET['Product'];
		$model->organization_id = $organization_id;
		if(Yii::app()->request->getParam('clearFilters')) EButtonColumnWithClearFilters::clearFilters($this,$model);

		$this->render('adminByOrganization',array(
			'model'=>$model,
			'organization'=>$model->organization,
			'realm'=>$realm
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
