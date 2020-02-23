<?php

use Symfony\Component\Yaml\Yaml;
use Exiang\YsUtil;

class DefaultController extends CController
{
	public $layout = 'default';
	protected $envDistFilePath;
	protected $envFilePath;
	protected $yamlParsed;

	public function init()
	{
		$this->envDistFilePath = dirname(__DIR__, 1) . '/../../../protected/dist.env';
		$this->envFilePath = dirname(__DIR__, 1) . '/../../../protected/.env';

		$configYamlFilePath = dirname(__DIR__, 1) . '/../../../protected/config/config.yaml';
		$this->yamlParsed = (extension_loaded('yaml')) ? yaml_parse_file($configYamlFilePath) : Yaml::parseFile($configYamlFilePath);
	}

	public function actionIndex()
	{
		$model = new SetupForm;
		$envs = array();
		// load existing .envs into array
		if (file_exists($this->envFilePath)) {
			$envs = (new josegonzalez\Dotenv\Loader($this->envFilePath))
	  ->parse()
	  ->toArray();
		}

		// base on yaml, preload .env to $model->envs as array
		foreach ($this->yamlParsed as $configKey => $config) {
			foreach ($config['groups'] as $configGroup) {
				foreach ($configGroup['items'] as $configItem) {
					if (isset($configItem['env'])) {
						if (isset($envs[$configItem['env']])) {
							if ($configItem['datatype'] == 'boolean') {
								$model->envs[$configItem['env']] = var_export($envs[$configItem['env']], true);
							} else {
								$model->envs[$configItem['env']] = $envs[$configItem['env']];
							}
						} else {
							$model->envs[$configItem['env']] = '';
						}

						// preload from existing .env (if found) to model
						if (isset($configItem['varInstaller'])) {
							if (isset($envs[$configItem['env']])) {
								if ($configItem['datatype'] == 'boolean') {
									$model->{$configItem['varInstaller']} = var_export($envs[$configItem['env']], true);
								} else {
									$model->{$configItem['varInstaller']} = $envs[$configItem['env']];
								}
							}
						}
					}
				}
			}
		}

		// submission
		if (isset($_POST['SetupForm'])) {
			$model->attributes = $_POST['SetupForm'];

			// assign model attributes to model env
			foreach ($this->yamlParsed as $configKey => $config) {
				foreach ($config['groups'] as $configGroup) {
					foreach ($configGroup['items'] as $configItem) {
						if (isset($configItem['env'])) {
							if (isset($configItem['varInstaller'])) {
								if (isset($model->{$configItem['varInstaller']})) {
									$model->envs[$configItem['env']] = $model->{$configItem['varInstaller']};
								}
							}
						}
					}
				}
			}

			//
			// modifier

			// environment
			// DEV, ENVIRONMENT
			if ($model->environment == 'production') {
				$model->envs['DEV'] = var_export(false, true);
			} elseif ($model->environment == 'staging') {
				$model->envs['DEV'] = var_export(true, true);
			} elseif ($model->environment == 'testing') {
				$model->envs['DEV'] = var_export(true, true);
			} elseif ($model->environment == 'development') {
				$model->envs['DEV'] = var_export(true, true);
			}

			// domainName
			// BASE_DOMAIN, MASTER_URL, BASE_URL, CSRF_COOKIE, REQUEST_HOST_INFO, BASE_API_URL
			$model->envs['MASTER_DOMAIN'] = $model->domainName;
			$model->envs['MASTER_URL'] = '//' . $model->domainName;
			$model->envs['BASE_DOMAIN'] = $model->domainName;
			$model->envs['BASE_URL'] = '//' . $model->domainName;
			$parsedDomainName = parse_url('https://' . $model->domainName);
			$model->envs['CSRF_COOKIE'] = '.' . $parsedDomainName['host'];
			$model->envs['REQUEST_HOST_INFO'] = 'https://' . $model->domainName;
			$model->envs['BASE_API_URL'] = 'https://api-' . $model->domainName;

			// connect
			$model->envs['CONNECT_SECRET_KEY_API'] = 'b6YDWvZFvFW4leBap9GiiTBq4VRmfzznLJAekcCr';
			// CORS
			$model->envs['CORS'] = 'https:' . $model->connectUrl . ';';

			$model->envs['MAINTENANCE'] = var_export(false, true);
			$model->envs['THEME'] = 'inspinia';
			$model->envs['LANGUAGE'] = 'en';
			$model->envs['LANGUAGES'] = 'en:English;ms:Bahasa Melayu;zh:中文';
			$model->envs['FRONTEND_LANGUAGES'] = 'en:English;ms:Bahasa Melayu';
			$model->envs['BACKEND_LANGUAGES'] = 'en:English;ms:Bahasa Melayu';
			$model->envs['CURRENCY'] = 'MYR';
			$model->envs['SOURCE_CURRENCY'] = 'USD';
			$model->envs['ENFORCE_API_SSL'] = var_export(true, true);
			$model->envs['JWT_SECRET'] = YsUtil::generateRandomPassword(64, 32);
			$model->envs['SALT_SECRET'] = YsUtil::generateRandomPassword(64, 32);
			$model->envs['STORAGE_MODE'] = 's3';
			$model->envs['THUMB_MODE'] = 'pre';
			$model->envs['S3_VERSION'] = '2006-03-01';
			$model->envs['S3_URL_SECURE_EXPIRY_TIME'] = '+30 minutes';
			$model->envs['IMAGE_DRIVER'] = 'GD';
			$model->envs['MOBILE_VERIFICATION_RESEND_LIMIT'] = '5';
			$model->envs['SMTP_AUTH'] = var_export(true, true);
			$model->envs['ESLOG_INDEX_CODE'] = sprintf('log-%s', str_replace('.', '-', $model->domainName));
			$model->envs['MODULE_EGG_PASSWORD'] = YsUtil::generateRandomPassword(6, 6);
			$model->envs['MODULE_GII_PASSWORD'] = YsUtil::generateRandomPassword(6, 6);
			$model->envs['MODULE_YEE_PASSWORD'] = YsUtil::generateRandomPassword(6, 6);

			//print_r($model->envs);exit;
			//echo $model->envs['MAINTENANCE'];exit;

			// generate /protected/.env
			$envBuffer = '';
			foreach ($this->yamlParsed as $configKey => $config) {
				foreach ($config['groups'] as $configGroup) {
					foreach ($configGroup['items'] as $configItem) {
						if (isset($configItem['env'])) {
							if (isset($model->envs[$configItem['env']])) {
								if ($configItem['datatype'] == 'boolean') {
									$envBuffer .= sprintf("%s=%s # %s\n", $configItem['env'], ($model->envs[$configItem['env']] == 'true' ? 'true' : 'false'), isset($configItem['hint']) ? $configItem['hint'] : '');
								} elseif ($configItem['datatype'] == 'string' || $configItem['datatype'] == 'password' || $configItem['datatype'] == 'email' || $configItem['datatype'] == 'url' || $configItem['datatype'] == 'enum') {
									if (!empty($model->envs[$configItem['env']])) {
										$envBuffer .= sprintf("%s=%s # %s\n", $configItem['env'], str_replace('\'', '"', strval(var_export($model->envs[$configItem['env']], true))), isset($configItem['hint']) ? $configItem['hint'] : '');
									}
								} else {
									$envBuffer .= sprintf("%s=%s # %s\n", $configItem['env'], $model->envs[$configItem['env']], isset($configItem['hint']) ? $configItem['hint'] : '');
								}
							} else {
								$envBuffer .= sprintf("%s=\n # %s", $configItem['env'], isset($configItem['hint']) ? $configItem['hint'] : '');
							}
						}
					}
				}
			}

			//echo $envBuffer;exit;
			file_put_contents($this->envFilePath, $envBuffer);
			// load database sql
	  // create admin account if not exists
		}

		$this->render('index', array('model' => $model));
	}
}
