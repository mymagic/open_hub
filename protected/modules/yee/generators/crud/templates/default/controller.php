<?php
 /*************************************************************************
 *
 * TAN YEE SIANG CONFIDENTIAL
 * __________________
 *
 *  [2002] - [2007] TAN YEE SIANG
 *  All Rights Reserved.
 *
 * NOTICE:  All information contained herein is, and remains
 * the property of TAN YEE SIANG and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to TAN YEE SIANG
 * and its suppliers and may be covered by U.S. and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from TAN YEE SIANG.
 */
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php $hasOrdering = false; ?>
<?php echo "<?php\n"; ?>
class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass . "\n"; ?>
{
	/**
	 * @var string the default layout for the views. Defaults to 'layouts.backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout='<?php $layout = $this->buildSetting->getLayout(); echo !empty($layout) ? $layout : 'backend'; ?>';

	public function actions()
	{
		return array
		(
 <?php 
 foreach ($this->tableSchema->columns as $column) {
 	if ($this->buildSetting->isOrderingColumn($column)) {
 		$hasOrdering = true; ?>

			'order' => array
			(
				'class' => 'application.yeebase.extensions.OrderColumn.OrderAction',
				'modelClass' => '<?php echo $this->modelClass; ?>',
				'pkName'  => 'id',
				'backToAction' => 'admin',
			),
<?php
		break;
 	}
 }
?>
		);
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			<?php if (!$this->buildSetting->isDeleteDisabled()) : ?>'postOnly + delete', // we only allow deletion via POST request<?php endif; ?>
		
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
				'actions'=>array('list','view','create','update','admin'<?php if (!$this->buildSetting->isDeleteDisabled()):?>,'delete'<?php endif; ?> <?php if ($hasOrdering): ?>,'order'<?php endif; ?>),
				'users'=>array('@'),
				// 'expression'=>"\$user->isAdmin==true",
				'expression'=>'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];

<?php foreach ($this->tableSchema->columns as $column) {
	// date but not added & modified
	if ($this->buildSetting->isDateColumn($column) && ($column->name != 'date_added' && $column->name != 'date_modified')) {
		echo "\t\t\tif(!empty(\$model->{$column->name})) \$model->{$column->name} = strtotime(\$model->{$column->name});\n";
	}
	// image
	elseif ($this->buildSetting->isImageColumn($column)) {
		$imageFileName = str_replace('image_', 'imageFile_', $column->name);
		echo "\t\t\t\$model->{$imageFileName} = UploadedFile::getInstance(\$model, '{$imageFileName}');\n";
	} elseif ($this->buildSetting->isFileColumn($column)) {
		$uploadFileName = str_replace('file_', 'uploadFile_', $column->name);
		echo "\t\t\t\$model->{$uploadFileName} = UploadedFile::getInstance(\$model, '{$uploadFileName}');\n";
	}
}
?>
	
			if($model->save())
			{
<?php
 foreach ($this->tableSchema->columns as $column) {
 	// image
 	if ($this->buildSetting->isImageColumn($column)) {
 		$imageFileName = str_replace('image_', 'imageFile_', $column->name);
 		$imageColumnName = str_replace('image_', '', $column->name);

 		echo sprintf("\t\t\t\tUploadManager::storeImage(\$model, '%s', \$model->tableName());\n", $imageColumnName);
 	}
 	// file
 	elseif ($this->buildSetting->isFileColumn($column)) {
 		$uploadFileName = str_replace('file_', 'uploadFile_', $column->name);
 		$uploadColumnName = str_replace('file_', '', $column->name);

 		echo sprintf("\t\t\t\tUploadManager::storeFile(\$model, '%s', \$model->tableName());\n", $uploadColumnName);
 	}
 }

// tag
$tags = $this->buildSetting->getTags();
if (!empty($tags)) {
	foreach ($tags as $tagKey => $tagValues) {
		echo sprintf("\t\t\t\t\$model->setTags(\$model->tag_%s)->save();\n", $tagKey);
	}
}
?>
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];

<?php foreach ($this->tableSchema->columns as $column) {
	// date
	if ($this->buildSetting->isDateColumn($column) && ($column->name != 'date_added' && $column->name != 'date_modified')) {
		echo "\t\t\tif(!empty(\$model->{$column->name})) \$model->{$column->name} = strtotime(\$model->{$column->name});\n";
	}
	// image
	elseif ($this->buildSetting->isImageColumn($column)) {
		$imageFileName = str_replace('image_', 'imageFile_', $column->name);
		echo "\t\t\t\$model->{$imageFileName} = UploadedFile::getInstance(\$model, '{$imageFileName}');\n";
	}
	// file
	elseif ($this->buildSetting->isFileColumn($column)) {
		$uploadFileName = str_replace('file_', 'uploadFile_', $column->name);
		echo "\t\t\t\$model->{$uploadFileName} = UploadedFile::getInstance(\$model, '{$uploadFileName}');\n";
	}
}
?>

			if($model->save())
			{
<?php
 foreach ($this->tableSchema->columns as $column) {
 	// image
 	if (substr($column->name, 0, 6) == 'image_') {
 		$imageFileName = str_replace('image_', 'imageFile_', $column->name);
 		$imageColumnName = str_replace('image_', '', $column->name);

 		echo sprintf("\t\t\t\tUploadManager::storeImage(\$model, '%s', \$model->tableName());\n", $imageColumnName);
 	}
 	// file
 	elseif (substr($column->name, 0, 5) == 'file_') {
 		$uploadFileName = str_replace('file_', 'uploadFile_', $column->name);
 		$uploadColumnName = str_replace('file_', '', $column->name);

 		echo sprintf("\t\t\t\tUploadManager::storeFile(\$model, '%s', \$model->tableName());\n", $uploadColumnName);
 	}
 }

// tag
$tags = $this->buildSetting->getTags();
if (!empty($tags)) {
	foreach ($tags as $tagKey => $tagValues) {
		echo sprintf("\t\t\t\t\$model->setTags(\$model->tag_%s)->save();\n", $tagKey);
	}
}
?>
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	<?php if (!$this->buildSetting->isDeleteDisabled()): ?>
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	<?php endif; ?>

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('<?php echo $this->class2id($this->modelClass); ?>/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		<?php if ($hasOrdering): ?>$dataProvider->criteria->order =  'ordering ASC';<?php endif; ?>
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
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>'])) $model->attributes=$_GET['<?php echo $this->modelClass; ?>'];
		if(Yii::app()->request->getParam('clearFilters')) EButtonColumnWithClearFilters::clearFilters($this,$model);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return <?php echo $this->modelClass; ?> the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
