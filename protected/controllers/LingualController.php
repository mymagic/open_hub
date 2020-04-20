<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class LingualController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *             using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'backend';

	public function actions()
	{
		return array(
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('deny',  // deny if make is reporting
				'expression' => "\Yii::app()->params['make']==reporting",
			),
			array('allow',
				'actions' => array('index', 'admin'),
				'users' => array('@'),
				// 'expression' => '$user->isContentManager==true || $user->isSuperAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow',
				'actions' => array('translate'),
				'users' => array('@'),
				// 'expression' => '$user->isContentManager==true || $user->isSuperAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow',
				'actions' => array('editPredefined', 'rescan'),
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true || $user->isSuperAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->redirect('admin');
	}

	public function actionAdmin()
	{
		$scopeFiles = scandir(Yii::getPathOfAlias('messages') . DIRECTORY_SEPARATOR . Yii::app()->language);
		foreach ($scopeFiles as $sf) {
			if ($sf != '.' && $sf != '..') {
				$scopes[] = str_replace('.php', '', $sf);
			}
		}

		$this->render('admin', array('scopes' => $scopes));
	}

	public function actionTranslate($scope, $lingual)
	{
		$phpMaxInputLimit = ini_get('max_input_vars');
		$canSave = true;
		$items = array();

		$filePath = sprintf('%s%s%s%s%s.php', Yii::getPathOfAlias('messages'), DIRECTORY_SEPARATOR, $lingual, DIRECTORY_SEPARATOR, $scope);
		$items[$lingual] = include $filePath;
		$totalInputRequired = ceil(count($items[$lingual]) * 2.1);
		if ($phpMaxInputLimit < $totalInputRequired) {
			Notice::flash(Yii::t('backend', 'Form has been disabled to prevent error while saving. Please contact your server admin to increase your PHP max_input_vars value to at least {totalInputRequired} or more.', ['{totalInputRequired}' => $totalInputRequired]), Notice_ERROR);
			$canSave = false;
		}

		if (isset($_POST['YII_CSRF_TOKEN'])) {
			$buffer = "<?php\nreturn array (\n";
			$totalLine = count($_POST['langKey']);

			for ($i = 0; $i < $totalLine; ++$i) {
				$buffer .= sprintf("\n\t'%s' => '%s',", addcslashes($_POST['langKey'][$i], "'"), addcslashes(trim($_POST['langValue'][$i]), "'"));
			}
			$buffer .= "\n);\n?>";
			if (file_put_contents($filePath, $buffer)) {
				Notice::flash(Yii::t('notice', 'Your translation on \'{scope}\' for language \'{language}\' is successfully saved.', ['{scope}' => $scope, '{language}' => Yii::app()->params['languages'][$lingual]]), Notice_SUCCESS);
				$this->redirect(array('lingual/translate', 'scope' => $scope, 'lingual' => $lingual, 'rand' => rand()));
			}
		}

		$this->render('translate', array('scope' => $scope, 'lingual' => $lingual, 'items' => $items, 'canSave' => $canSave));
	}

	public function actionRescan()
	{
		$this->render('rescan');
	}

	public function actionEditPredefined($scope)
	{
		$canSave = false;
		$filePath = Yii::getPathOfAlias('data') . DIRECTORY_SEPARATOR . 'message' . DIRECTORY_SEPARATOR . $scope . '.tag.tpl';

		if (isset($_POST['YII_CSRF_TOKEN']) && isset($_POST['content'])) {
			$buffer = $_POST['content'];
			file_put_contents($filePath, $buffer);
			Notice::flash(Yii::t('notice', 'Your predefined tag on \'{scope}\' is successfully saved.', ['{scope}' => $scope]), Notice_SUCCESS);
		}

		$content = file_get_contents($filePath);

		$this->render('editPredefined', array('scope' => $scope, 'filePath' => $filePath, 'content' => $content, 'canSave' => $canSave));
	}
}
