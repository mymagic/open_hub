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
use Symfony\Component\Yaml\Yaml;

class SwaggerController extends Controller
{
	public $apiBaseUrl;

	public $layout = 'swagger';

	// disable csrf
	public function beforeAction($action)
	{
		$this->apiBaseUrl = Yii::app()->params['baseApiUrl'];

		$this->layoutParams['bodyClass'] = str_replace('gray-bg', '', $this->layoutParams['bodyClass']);

		return parent::beforeAction($action);
	}

	public function actionIndex($code = '', $format = 'yaml', $module = '')
	{
		// todo: have problem on php7 with error '[] operator not supported for strings'

		//echo fnmatch('wapi/*', 'wapi/v1');exit;
		$this->apiBaseUrl = Yii::app()->params['baseApiUrl'];
		$apis = array();

		// find all api from default /data/api folder
		$dataPath = Yii::getPathOfAlias('data');
		$filePath = sprintf('%s/api', $dataPath);
		$files = YsUtil::listDir($filePath);

		if (!empty($files)) {
			foreach ($files as $file) {
				$fileFormat = YsUtil::getFileExtension($file);
				$fileName = YsUtil::getFileName($file);
				$fileCode = str_replace('.' . $fileFormat, '', $fileName);

				$apis[$fileCode] = array('code' => $fileCode, 'fileName' => $fileName, 'format' => $fileFormat);
			}
		}

		// find all api from module /module/data/api folder
		$modules = YeeModule::getParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			$modulePath = Yii::getPathOfAlias('modules');
			$filePath = sprintf('%s/%s/data/api', $modulePath, $moduleKey);
			$files = YsUtil::listDir($filePath);
			if (!empty($files)) {
				foreach ($files as $file) {
					$fileFormat = YsUtil::getFileExtension($file);
					$fileName = YsUtil::getFileName($file);
					$fileCode = str_replace('.' . $fileFormat, '', $fileName);

					$apis[$fileCode] = array('code' => $fileCode, 'fileName' => $fileName, 'format' => $fileFormat, 'module' => $moduleKey);
				}
			}
		}

		ksort($apis);

		// echo '<pre>';print_r($apis);exit;

		$this->render('index', array('code' => $code, 'format' => $format, 'apis' => $apis, 'module' => $module));
	}

	public function actionGetApiDef($code, $format, $module = '')
	{
		if (empty($module)) {
			$dataPath = Yii::getPathOfAlias('data');
			$filePath = sprintf('%s/api/%s.%s', $dataPath, $code, $format);
		} else {
			$filePath = sprintf('%s/%s/data/api/%s.%s', Yii::getPathOfAlias('modules'), $module, $code, $format);
		}

		// hard set host and path base on environment
		// required php-yaml module
		if ($format == 'yaml') {
			$yamlParsed = (extension_loaded('yaml')) ? yaml_parse_file($filePath) : Yaml::parseFile($filePath);

			$urlParsed = parse_url(Yii::app()->params['baseApiUrl']);
			$yamlParsed['host'] = $urlParsed['host'];
			$yamlParsed['basePath'] = $urlParsed['path'];
			echo (extension_loaded('yaml')) ? yaml_emit($yamlParsed) : Yaml::dump($yamlParsed);
		} elseif ($format == 'json') {
			throw new Exception('Not Implemented yet');
		} else {
			echo file_get_contents($filePath);
		}

		Yii::app()->end();
	}
}
