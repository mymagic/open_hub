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

Yii::import('application.modules.yee.components.BuildSetting');
class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $baseControllerClass = 'Controller';
	public $buildSetting;

	private $_modelClass;
	private $_table;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter' => 'trim'),
			array('model, controller, baseControllerClass', 'required'),
			array('model', 'match', 'pattern' => '/^\w+[\w+\\.]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern' => '/^\w+[\w+\\/]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern' => '/^[a-zA-Z_][\w\\\\]*$/', 'message' => '{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError' => true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model' => 'Model Class',
			'controller' => 'Controller ID',
			'baseControllerClass' => 'Base Controller Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if (Yii::app()->db === null) {
			throw new CHttpException(500, 'An active "db" connection is required to run this generator.');
		}
		parent::init();
	}

	public function successMessage()
	{
		$link = Html::link('try it now', Yii::app()->createUrl($this->controller), array('target' => '_blank'));

		return "The controller has been generated successfully. You may $link.";
	}

	public function validateModel($attribute, $params)
	{
		if ($this->hasErrors('model')) {
			return;
		}
		$class = @Yii::import($this->model, true);
		if (!is_string($class) || !$this->classExists($class)) {
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		} elseif (!is_subclass_of($class, 'CActiveRecord')) {
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		} else {
			$table = CActiveRecord::model($class)->tableSchema;
			if ($table->primaryKey === null) {
				$this->addError('model', "Table '{$table->name}' does not have a primary key.");
			} elseif (is_array($table->primaryKey)) {
				$this->addError('model', "Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			} else {
				$this->_modelClass = $class;
				$this->_table = $table;
			}
		}
	}

	public function prepare()
	{
		// exiang: include user defined buildSettings

		if (!empty($this->getModule())) {
			$moduleName = $this->getModule()->id;
		}

		$this->buildSetting = new BuildSetting();
		$this->buildSetting->loadBuildFile($this->_table->name, $moduleName);
		//$this->buildSetting->test();

		$this->files = array();
		$templatePath = $this->templatePath;
		$controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';

		$this->files[] = new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files = scandir($templatePath);
		foreach ($files as $file) {
			if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php') {
				$this->files[] = new CCodeFile(
					$this->viewPath . DIRECTORY_SEPARATOR . $file,
					$this->render($templatePath . '/' . $file)
				);
			}
		}
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if (($pos = strrpos($this->controller, '/')) !== false) {
			return ucfirst(substr($this->controller, $pos + 1)) . 'Controller';
		} else {
			return ucfirst($this->controller) . 'Controller';
		}
	}

	public function getModule()
	{
		if (($pos = strpos($this->controller, '/')) !== false) {
			$id = substr($this->controller, 0, $pos);
			if (($module = Yii::app()->getModule($id)) !== null) {
				return $module;
			}
		}

		return Yii::app();
	}

	public function getControllerID()
	{
		if ($this->getModule() !== Yii::app()) {
			$id = substr($this->controller, strpos($this->controller, '/') + 1);
		} else {
			$id = $this->controller;
		}
		if (($pos = strrpos($id, '/')) !== false) {
			$id[$pos + 1] = strtolower($id[$pos + 1]);
		} else {
			$id[0] = strtolower($id[0]);
		}

		return $id;
	}

	public function getUniqueControllerID()
	{
		$id = $this->controller;
		if (($pos = strrpos($id, '/')) !== false) {
			$id[$pos + 1] = strtolower($id[$pos + 1]);
		} else {
			$id[0] = strtolower($id[0]);
		}

		return $id;
	}

	public function getControllerFile()
	{
		$module = $this->getModule();
		$id = $this->getControllerID();
		if (($pos = strrpos($id, '/')) !== false) {
			$id[$pos + 1] = strtoupper($id[$pos + 1]);
		} else {
			$id[0] = strtoupper($id[0]);
		}

		return $module->getControllerPath() . '/' . $id . 'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath() . '/' . $this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass, $column)
	{
		return "Html::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass, $column)
	{
		if ($column->type === 'boolean') {
			return "Html::activeCheckBox(\$model,'{$column->name}')";
		} elseif (stripos($column->dbType, 'text') !== false) {
			return "Html::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		} else {
			if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
				$inputField = 'activePasswordField';
			} else {
				$inputField = 'activeTextField';
			}

			if ($column->type !== 'string' || $column->size === null) {
				return "Html::{$inputField}(\$model,'{$column->name}')";
			} else {
				if (($size = $maxLength = $column->size) > 60) {
					$size = 60;
				}

				return "Html::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass, $column)
	{
		//return "\$form->labelEx(\$model,'{$column->name}')";
		return "\$form->bsLabelEx2(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass, $column, $type = 'default')
	{
		// boolean
		if ($column->type === 'boolean') {
			return "\$form->checkBox(\$model,'{$column->name}')";
		}
		// others
		else {
			// default to text
			$inputField = 'bsTextField';

			// foreign
			if ($this->buildSetting->isForeignKeyColumn($column->name)) {
				if ($type == 'search') {
					return "\$form->bsForeignKeyDropDownList(\$model, '{$column->name}', array('nullable'=>true))";
				}

				return "\$form->bsForeignKeyDropDownList(\$model, '{$column->name}')";
			}
			// enum
			elseif ($this->buildSetting->isEnumColumn($column)) {
				if ($type == 'search') {
					return "\$form->bsEnumDropDownList(\$model, '{$column->name}', array('nullable'=>true))";
				}

				return "\$form->bsEnumDropDownList(\$model, '{$column->name}')";
			}
			// long text
			elseif ($this->buildSetting->isTextColumn($column)) {
				return "\$form->bsTextArea(\$model,'{$column->name}',array('rows'=>2))";
			}
			// url
			elseif ($this->buildSetting->isUrlColumn($column)) {
				return "\$form->bsUrlTextField(\$model,'{$column->name}')";
			}
			// password
			elseif ($this->buildSetting->isPasswordColumn($column)) {
				$inputField = 'bsPasswordField';
			}
			// date field
			elseif ($this->buildSetting->isDateColumn($column)) {
				$inputField = 'bsDateTextField';
				// if search, date must be nullable
				if ($type == 'search') {
					return "\$form->{$inputField}(\$model, '{$column->name}', array('nullable'=>true))";
				}
			}
			// boolean
			elseif ($this->buildSetting->isBooleanColumn($column)) {
				$inputField = 'bsBooleanList';
				// if search, boolean must be nullable
				if ($type == 'search') {
					return "\$form->{$inputField}(\$model, '{$column->name}', array('nullable'=>true))";
				}
			}
			// csv
			elseif ($this->buildSetting->isCsvColumn($column)) {
				$inputField = 'bsCsvTextField';
				// if search, boolean must be nullable
				if ($type == 'search') {
					$inputField = 'bsTextField';
				}
			}
			// image
			elseif ($this->buildSetting->isImageColumn($column)) {
				$imageFileName = str_replace('image_', 'imageFile_', $column->name);

				return "Html::activeFileField(\$model, '{$imageFileName}')";
			}
			// file
			elseif ($this->buildSetting->isFileColumn($column)) {
				$imageFileName = str_replace('file_', 'uploadFile_', $column->name);

				return "Html::activeFileField(\$model, '{$imageFileName}')";
			}
			// text
			elseif (stripos($column->dbType, 'text') !== false) {
				// html
				if ($this->buildSetting->isHtmlColumn($column)) {
					$inputField = 'bsHtmlEditor';
				}
				// textarea
				else {
					return "\$form->bsTextArea(\$model, '{$column->name}', array('rows'=>5))";
				}
			}

			return "\$form->{$inputField}(\$model, '{$column->name}')";
		}
	}

	public function guessNameColumn($columns)
	{
		foreach ($columns as $column) {
			if (!strcasecmp($column->name, 'name')) {
				return $column->name;
			}
		}
		foreach ($columns as $column) {
			if (!strcasecmp($column->name, 'title')) {
				return $column->name;
			}
		}
		foreach ($columns as $column) {
			if ($column->isPrimaryKey) {
				return $column->name;
			}
		}

		return 'id';
	}
}
