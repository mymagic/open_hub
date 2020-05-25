<?php

use Symfony\Component\Yaml\Yaml;
use Exiang\YsUtil\YsUtil;

class DefaultController extends CController
{
	public $layout = 'default';
	protected $envDistFilePath;
	protected $envFilePath;
	protected $baseSqlFilePath;
	protected $yamlParsed;

	public function init()
	{
		$this->envDistFilePath = dirname(__DIR__, 1) . '/../../../protected/dist.env';
		$this->envFilePath = dirname(__DIR__, 1) . '/../../../protected/.env';
		$this->baseSqlFilePath = dirname(__DIR__, 1) . '/data/base.sql';

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
			$model->envs['BASE_API_URL'] = 'https://api-' . $model->domainName . '/v1';

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
			if (file_exists($this->envFilePath)) {
				chmod($this->envFilePath, 0777);
			}
			file_put_contents($this->envFilePath, $envBuffer);

			$this->redirect(array('setupDb'));
		}

		$this->render('index', array('model' => $model));
	}

	// load database sql
	public function actionSetupDb()
	{
		set_time_limit(0);

		$envs = array();
		// load existing .envs into array
		if (file_exists($this->envFilePath)) {
			$envs = (new josegonzalez\Dotenv\Loader($this->envFilePath))
	  ->parse()
	  ->toArray();
		}

		$mysqli = new mysqli($envs['DB_HOST'], $envs['DB_USERNAME'], $envs['DB_PASSWORD'], $envs['DB_DATABASE']);
		$mysqli->set_charset('utf8');
		if ($mysqli->connect_errno) {
			echo 'Failed to connect to Database: ' . $mysqli->connect_error;
			exit();
		}

		// make sure database is empty, else refuse to proceed
		$sql = sprintf('SHOW TABLES FROM `%s`', $envs['DB_DATABASE']);
		$result = $mysqli->query($sql);

		if (!$result) {
			echo "DB Error, could not list tables\n";
			exit;
		}

		if ($result->num_rows > 0) {
			echo 'Failed to proceed, database is not empty';
		} else {
			set_time_limit(0);
			header('Content-Type: text/html;charset=utf-8');
			if (self::sqlImport($this->baseSqlFilePath, $mysqli)) {
				$this->redirect(array('done'));
			} else {
				echo 'Failed to import SQL due to unknown error';
			}
		}
	}

	// create admin account if not exists
	public function actionDone()
	{
		set_time_limit(0);

		$envs = array();
		// load existing .envs into array
		if (file_exists($this->envFilePath)) {
			$envs = (new josegonzalez\Dotenv\Loader($this->envFilePath))
			->parse()
			->toArray();
		}

		// create admin if not found
		$adminUsername = $envs['ADMIN_EMAIL'];
		$adminFirstname = 'Admin';
		$adminLastname = preg_replace('/@.*?$/', '', $adminUsername);
		$newPassword = rand(100000, 999999);
		$salt = sprintf('%s.%s', $adminUsername, $envs['SALT_SECRET']);
		$encryptedPassword = password_hash(hash_hmac('sha256', $newPassword, $salt), PASSWORD_BCRYPT);
		$now = time();

		$dbConnection = new CDbConnection(sprintf('mysql:host=%s;dbname=%s', $envs['DB_HOST'], $envs['DB_DATABASE']), $envs['DB_USERNAME'], $envs['DB_PASSWORD']);
		$dbConnection->active = true;

		// check is admin exists?
		$sql = sprintf("SELECT user_id FROM admin WHERE username LIKE '%s'", addslashes($adminUsername));
		$command = $dbConnection->createCommand($sql);
		$adminUserId = $command->queryScalar();

		if (empty($adminUserId)) {
			$transaction = $dbConnection->beginTransaction();

			// admin not exists
			try {
				// create user
				$dbConnection->createCommand()->insert('user', array(
					'username' => $adminUsername,
					'password' => $encryptedPassword,
					'signup_type' => 'admin',
					'is_active' => 1,
					'date_activated' => $now,
					'date_added' => $now,
					'date_modified' => $now,
				));
				$userId = $dbConnection->getLastInsertID();

				// create profile
				$dbConnection->createCommand()->insert('profile', array(
					'user_id' => $userId,
					'full_name' => 'Super Admin',
					'date_added' => $now,
					'date_modified' => $now,
				));

				// create member
				$dbConnection->createCommand()->insert('member', array(
					'user_id' => $userId,
					'username' => $adminUsername,
					'date_joined' => $now,
					'date_added' => $now,
					'date_modified' => $now,
				));

				// create admin
				$dbConnection->createCommand()->insert('admin', array(
					'user_id' => $userId,
					'username' => $adminUsername,
					'date_added' => $now,
					'date_modified' => $now,
				));

				// create role2user
				// super admin
				$dbConnection->createCommand()->insert('role2user', array(
					'role_id' => '1',
					'user_id' => $userId,
				));
				// admin
				$dbConnection->createCommand()->insert('role2user', array(
					'role_id' => '3',
					'user_id' => $userId,
				));
				// roleManager
				$dbConnection->createCommand()->insert('role2user', array(
					'role_id' => '4',
					'user_id' => $userId,
				));
				// adminManager
				$dbConnection->createCommand()->insert('role2user', array(
					'role_id' => '5',
					'user_id' => $userId,
				));
				// sensitiveDataAdmin
				$dbConnection->createCommand()->insert('role2user', array(
					'role_id' => '11',
					'user_id' => $userId,
				));

				$transaction->commit();
			} catch (Exception $e) {
				$exceptionMessage = $e->getMessage();
				$transaction->rollBack();
			}
		}

		$this->render('done', array(
			'appName' => $envs['HUB_NAME'],
			'adminUsername' => $envs['ADMIN_EMAIL'],
			'eggPassword' => $envs['MODULE_EGG_PASSWORD'],
			'giiPassword' => $envs['MODULE_GII_PASSWORD'],
			'yeePassword' => $envs['MODULE_YEE_PASSWORD'],
		));
	}

	public function sqlImport($file, $mysqli)
	{
		$delimiter = ';';
		$file = fopen($file, 'r');
		$isFirstRow = true;
		$isMultiLineComment = false;
		$sql = '';

		while (!feof($file)) {
			$row = fgets($file);

			// remove BOM for utf-8 encoded file
			if ($isFirstRow) {
				$row = preg_replace('/^\x{EF}\x{BB}\x{BF}/', '', $row);
				$isFirstRow = false;
			}

			// 1. ignore empty string and comment row
			if (trim($row) == '' || preg_match('/^\s*(#|--\s)/sUi', $row)) {
				continue;
			}

			// 2. clear comments
			$row = trim(self::clearSQL($row, $isMultiLineComment));

			// 3. parse delimiter row
			if (preg_match('/^DELIMITER\s+[^ ]+/sUi', $row)) {
				$delimiter = preg_replace('/^DELIMITER\s+([^ ]+)$/sUi', '$1', $row);
				continue;
			}

			// 4. separate sql queries by delimiter
			$offset = 0;
			while (strpos($row, $delimiter, $offset) !== false) {
				$delimiterOffset = strpos($row, $delimiter, $offset);
				if (self::isQuoted($delimiterOffset, $row)) {
					$offset = $delimiterOffset + strlen($delimiter);
				} else {
					$sql = trim($sql . ' ' . trim(substr($row, 0, $delimiterOffset)));
					self::query($sql, $mysqli);

					$row = substr($row, $delimiterOffset + strlen($delimiter));
					$offset = 0;
					$sql = '';
				}
			}
			$sql = trim($sql . ' ' . $row);
		}
		if (strlen($sql) > 0) {
			self::query($row, $mysqli);
		}

		fclose($file);

		return true;
	}

	/**
	 * Remove comments from sql
	 *
	 * @param string sql
	 * @param boolean is multicomment line
	 * @return string
	 */
	public function clearSQL($sql, &$isMultiComment)
	{
		if ($isMultiComment) {
			if (preg_match('#\*/#sUi', $sql)) {
				$sql = preg_replace('#^.*\*/\s*#sUi', '', $sql);
				$isMultiComment = false;
			} else {
				$sql = '';
			}
			if (trim($sql) == '') {
				return $sql;
			}
		}

		$offset = 0;
		while (preg_match('{--\s|#|/\*[^!]}sUi', $sql, $matched, PREG_OFFSET_CAPTURE, $offset)) {
			list($comment, $foundOn) = $matched[0];
			if (self::isQuoted($foundOn, $sql)) {
				$offset = $foundOn + strlen($comment);
			} else {
				if (substr($comment, 0, 2) == '/*') {
					$closedOn = strpos($sql, '*/', $foundOn);
					if ($closedOn !== false) {
						$sql = substr($sql, 0, $foundOn) . substr($sql, $closedOn + 2);
					} else {
						$sql = substr($sql, 0, $foundOn);
						$isMultiComment = true;
					}
				} else {
					$sql = substr($sql, 0, $foundOn);
					break;
				}
			}
		}

		return $sql;
	}

	/**
	 * Check if "offset" position is quoted
	 *
	 * @param int $offset
	 * @param string $text
	 * @return boolean
	 */
	public function isQuoted($offset, $text)
	{
		if ($offset > strlen($text)) {
			$offset = strlen($text);
		}

		$isQuoted = false;
		for ($i = 0; $i < $offset; $i++) {
			if ($text[$i] == "'") {
				$isQuoted = !$isQuoted;
			}
			if ($text[$i] == '\\' && $isQuoted) {
				$i++;
			}
		}

		return $isQuoted;
	}

	public function query($sql, $mysqli)
	{
		//echo '#<strong>SQL CODE TO RUN:</strong><br>' . htmlspecialchars($sql) . ';<br><br>';
		if (!$query = $mysqli->query($sql)) {
			throw new Exception("Cannot execute request to the database {$sql}: " . $mysqli->error);
		}
	}
}
