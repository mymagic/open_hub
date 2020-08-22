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

use Intervention\HttpAuth\HttpAuth;
use Firebase\JWT\JWT;

class V1Controller extends Controller
{
	public function actions()
	{
		$return = array();

		// loop thru modules to find actions
		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			$modulePath = Yii::getPathOfAlias('modules');
			$actionsPath = sprintf('%s/%s/actions/wapi/V1Controller', $modulePath, $moduleKey);
			$files = YsUtil::listDir($actionsPath);
			if (!empty($files)) {
				foreach ($files as $file) {
					$functionName = basename($file, '.php');
					$return[$functionName] = sprintf('application.modules.%s.actions.wapi.V1Controller.%s', $moduleKey, $functionName);
				}
			}
		}

		return $return;
	}

	public function beforeAction($action)
	{
		// must use secure https
		if (Yii::app()->params['enforceApiSSL'] && !Yii::app()->getRequest()->getIsSecureConnection()) {
			header("HTTP/1.1 418 I'm a teapot");
			header('HTTP/1.1 404 Not Found');
			Yii::app()->end();
		}

		if (Yii::app()->params['enableApiAuth']) {
			$config = array(
				'type' => 'basic',
				'realm' => 'v1',
				'username' => Yii::app()->params['apiUsername'],
				'password' => Yii::app()->params['apiPassword'],
			);
			$httpauth = HttpAuth::make($config);
			$httpauth->secure();
		}

		// swagger
		// Content-Type, api_key, Authorization

		return parent::beforeAction($action);
	}

	public function init()
	{
		parent::init();
		Yii::app()->request->setBaseUrl(Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:' . Yii::app()->params['masterUrl']);
	}

	// todo: password protect the class
	public function outputMessage($msg, $meta = array())
	{
		$this->outputJson('', $msg, 'success', $meta);
	}

	public function outputSuccess($data, $meta = array(), $msg = '')
	{
		$this->outputJson($data, $msg, 'success', $meta);
	}

	public function outputFail($msg, $meta = array())
	{
		$this->outputJson($data, $msg, 'fail', $meta);
	}

	public function outputPipe($result)
	{
		$this->outputJson($result['data'], $result['msg'], ($result['status'] == 'success' || $result['success'] == true) ? true : false, $result['meta']);
	}

	// status can be boolean or string of success|fail
	public function output($data, $msg = '', $status = 'fail', $meta = array())
	{
		$this->outputJson($data, $msg = '', $status, $meta);
	}

	public function validateJwt($jwt, $meta = array())
	{
		if (!empty($jwt)) {
			try {
				$secretKey = base64_decode(Yii::app()->params['jwtSecret']);
				$token = JWT::decode($jwt, $secretKey, array('HS512'));

				return $token;
			} catch (Exception $e) {
				/*
				* the token was not able to be decoded.
				* this is likely because the signature was not able to be verified (tampered token)
				*/
				$this->outputFail('Unauthorized Access', $meta);
			}
		} else {
			$this->outputFail('Invalid Token', $meta);
		}
	}

	public function actionIndex()
	{
	}

	public function actionHelloWorld()
	{
		$this->outputMessage('Hello World');
	}

	public function actionNow()
	{
		$meta = array();
		$data = array('timestamp' => HUB::now(), 'rfc2822' => date('r', HUB::now()), 'iso8601' => date('c', HUB::now()));
		$this->outputSuccess($data, $meta);
	}

	public function actionTestPost()
	{
		//print_r(Yii::app()->request->getRestParams());exit;
		$meta = array();
		$var1 = Yii::app()->request->getPost('var1');
		$var2 = Yii::app()->request->getPost('var2');
		$meta['input']['var1'] = $var1;
		$meta['input']['var2'] = $var2;

		$data = sprintf('%s %s', $var1, $var2);
		$this->outputSuccess($data, $meta);
	}

	public function actionSum($num1, $num2)
	{
		$meta['input']['num1'] = $num1;
		$meta['input']['num2'] = $num2;

		$this->outputSuccess($num1 + $num2, $meta);
	}

	public function actionAbsoluteUrl()
	{
		$this->outputSuccess(Yii::app()->createAbsoluteUrl('/'));
	}

	//
	// user
	public function actionGetUserJwt()
	{
		$meta = array();
		$username = Yii::app()->request->getPost('username');
		$meta['input']['username'] = $username;

		// if credential passed
		// in this case, just check user exists
		try {
			$user = HUB::getUserByUsername($username);
			// block non active user
			if (!$user->is_active) {
				throw new Exception(sprintf('User %s is not active', $username));
			}
			// everything ok, generate token
			$tokenId = base64_encode(openssl_random_pseudo_bytes(32));
			$issuedAt = HUB::now();
			//Adding 10 seconds
			$notBefore = $issuedAt + 10;
			// Adding 3600 seconds
			$expire = $notBefore + 3600;
			// Retrieve the server name from config file
			$serverName = Yii::app()->params['masterDomain'];

			// create the token as array
			$data = [
				// Issued at: time when the token was generated
				'iat' => $issuedAt,
				// Json Token Id: an unique identifier for the token
				'jti' => $tokenId,
				// Issuer
				'iss' => $serverName,
				// Not before
				'nbf' => $notBefore,
				// Expire
				'exp' => $expire,
				// Data related to the signer user
				'data' => [
					// userid from the users table
					'userId' => $user->id,
					// User name
					'username' => $username,
				],
			];

			$secretKey = base64_decode(Yii::app()->params['jwtSecret']);
			$jwt = JWT::encode($data, $secretKey, 'HS512');
			$result['jwt'] = $jwt;
			//print_r($user);exit;
			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetUserProfile()
	{
		$meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$meta['input']['jwt'] = $jwt;

		$token = $this->validateJwt($jwt, $meta);
		try {
			$user = HUB::getUserByUsername($token->data->username);
			//print_r($user->toApi());exit;
			$this->outputSuccess($user->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionRequestUserDataDownload()
	{
		$meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$format = Yii::app()->request->getPost('format');
		$meta['input']['jwt'] = $jwt;
		$meta['input']['format'] = $format;

		$token = $this->validateJwt($jwt, $meta);
		try {
			$user = HUB::getUserByUsername($token->data->username);
			$request = HUB::requestUserDataDownload($user, $format);

			$this->outputSuccess($request->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionListUserDataDownload()
	{
		$data = $meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$meta['input']['jwt'] = $jwt;

		$token = $this->validateJwt($jwt, $meta);
		try {
			$user = HUB::getUserByUsername($token->data->username);
			$list = HUB::listUserDataDownload($user);

			foreach ($list as $item) {
				$data[] = $item->toApi();
			}
			$this->outputSuccess($data, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	//
	// organization
	public function actionGetUserOrganizations()
	{
		$meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$meta['input']['jwt'] = $jwt;

		$token = $this->validateJwt($jwt, $meta);

		try {
			$tmps = HUB::getUserOrganizations($token->data->username);
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}

			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetUserOrganizationsCanJoin()
	{
		$meta = array();
		$jwt = Yii::app()->request->getPost('jwt');
		$keyword = Yii::app()->request->getPost('keyword');
		$meta['input']['jwt'] = $jwt;
		$meta['input']['keyword'] = $keyword;

		$token = $this->validateJwt($jwt, $meta);

		if (strlen($keyword) < 2) {
			$this->outputFail('Please insert longer keywoHUB', $meta);
		}

		try {
			$tmps = HUB::getUserOrganizationsCanJoin($keyword, $token->data->username);
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi(array('-products', '-impacts'));
			}

			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetOrganizationAllActive()
	{
		$meta = array();
		$searchTitle = Yii::app()->request->getPost('searchTitle');
		$searchAlpha = Yii::app()->request->getPost('searchAlpha');
		$persona = Yii::app()->request->getPost('persona');
		$industry = Yii::app()->request->getPost('industry');
		$magic = Yii::app()->request->getPost('magic');
		$page = Yii::app()->request->getPost('page');
		$limit = Yii::app()->request->getPost('limit');
		$meta['input']['searchTitle'] = $searchTitle;
		$meta['input']['searchAlpha'] = $searchAlpha;
		$meta['input']['persona'] = $persona;
		$meta['input']['industry'] = $industry;
		$meta['input']['magic'] = $magic;
		$meta['input']['page'] = $page;
		$meta['input']['limit'] = $limit;

		$tmps = HUB::getOrganizationAllActive(
			$page,
			array(
				'searchTitle' => $searchTitle,
				'searchAlpha' => $searchAlpha,
				'persona' => $persona,
				'industry' => $industry,
				'magic' => $magic,
			),
			$limit
		);

		if (!empty($tmps['items'])) {
			foreach ($tmps['items'] as $tmp) {
				$result[] = $tmp->toApi();
			}
		}

		$meta['output']['sql'] = $tmps['sql'];
		$meta['output']['limit'] = $tmps['limit'];
		$meta['output']['countPageItems'] = $tmps['countPageItems'];
		$meta['output']['totalItems'] = $tmps['totalItems'];
		$meta['output']['totalPages'] = $tmps['totalPages'];
		$meta['output']['filters'] = $tmps['filters'];

		$this->outputSuccess($result, $meta);
	}

	public function actionGetOrganizationByCode()
	{
		$meta = array();
		$code = Yii::app()->request->getPost('code');
		$meta['input']['code'] = $code;

		try {
			$organization = HUB::getOrganizationByCode($code);

			$this->outputSuccess($organization->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetOrganizationById()
	{
		$meta = array();
		$id = Yii::app()->request->getPost('id');
		$meta['input']['id'] = $id;

		try {
			$organization = HUB::getOrganization($id);

			$this->outputSuccess($organization->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetOrganizationByTitle()
	{
		$meta = array();
		$title = Yii::app()->request->getPost('title');
		$meta['input']['title'] = $title;
		header('Access-Control-Allow-Origin: *');
		try {
			$organization = Organization::title2obj($title);

			$this->outputSuccess($organization->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	//
	// product
	public function actionCreateProduct()
	{
		$meta = array();

		$title = Yii::app()->request->getPost('title');
		$userEmail = Yii::app()->request->getPost('userEmail');
		$organizationCode = Yii::app()->request->getPost('organizationCode');
		$productCategoryId = Yii::app()->request->getPost('productCategoryId');
		$shortDescription = Yii::app()->request->getPost('shortDescription');
		$typeof = Yii::app()->request->getPost('typeof');
		$urlWebsite = Yii::app()->request->getPost('urlWebsite');

		$meta['input']['title'] = $title;
		$meta['input']['userEmail'] = $userEmail;
		$meta['input']['organizationCode'] = $organizationCode;
		$meta['input']['productCategoryId'] = $productCategoryId;
		$meta['input']['shortDescription'] = $shortDescription;
		$meta['input']['typeof'] = $typeof;
		$meta['input']['urlWebsite'] = $urlWebsite;

		try {
			$params['productCategoryId'] = $productCategoryId;
			$params['shortDescription'] = $shortDescription;
			$params['typeof'] = $typeof;
			$params['urlWebsite'] = $urlWebsite;

			$organization = HUB::getOrganizationByCode($organizationCode);
			if ($organization == null) {
				throw new Exception('Organization not found');
			}
			$result = HUB::createProduct($title, $organization, $userEmail, $params);
			$this->outputSuccess($result->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionUpdateProduct()
	{
		$meta = array();

		$id = Yii::app()->request->getPost('id');
		$title = Yii::app()->request->getPost('title');
		$userEmail = Yii::app()->request->getPost('userEmail');
		$organizationCode = Yii::app()->request->getPost('organizationCode');
		$productCategoryId = Yii::app()->request->getPost('productCategoryId');
		$shortDescription = Yii::app()->request->getPost('shortDescription');
		$typeof = Yii::app()->request->getPost('typeof');
		$urlWebsite = Yii::app()->request->getPost('urlWebsite');

		$meta['input']['id'] = $id;
		$meta['input']['title'] = $title;
		$meta['input']['userEmail'] = $userEmail;
		$meta['input']['organizationCode'] = $organizationCode;
		$meta['input']['productCategoryId'] = $productCategoryId;
		$meta['input']['shortDescription'] = $shortDescription;
		$meta['input']['typeof'] = $typeof;
		$meta['input']['urlWebsite'] = $urlWebsite;

		try {
			$params['title'] = $title;
			$params['productCategoryId'] = $productCategoryId;
			$params['shortDescription'] = $shortDescription;
			$params['typeof'] = $typeof;
			$params['urlWebsite'] = $urlWebsite;

			$product = HUB::getProduct($id);
			if ($product == null) {
				throw new Exception('Product not found');
			}
			$result = HUB::updateProduct($product, $organizationCode, $userEmail, $params);
			$this->outputSuccess($result->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	//
	// idea
	// idea wishlist (deprecated)
	public function actionAddIdeaEnterprise2Wishlist()
	{
		$meta = array();
		$partnerCode = Yii::app()->request->getPost('partnerCode');
		$enterpriseCode = Yii::app()->request->getPost('enterpriseCode');
		$meta['input']['partnerCode'] = $partnerCode;
		$meta['input']['enterpriseCode'] = $enterpriseCode;

		try {
			$partner = HUB::getOrganizationByCode($partnerCode);
			$enterprise = HUB::getOrganizationByCode($enterpriseCode);

			$result = HubIdea::addEnterprise2Wishlist($partner, $enterprise);
			$this->outputSuccess($result->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetIdeaWishlist()
	{
		$meta = array();
		$id = Yii::app()->request->getPost('id');
		$meta['input']['id'] = $id;

		try {
			$result = HubIdea::getWishlist($id);
			$this->outputSuccess($result->toApi(), $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionRemoveIdeaEnterpriseFromWishlist()
	{
		$meta = array();
		$partnerCode = Yii::app()->request->getPost('partnerCode');
		$enterpriseCode = Yii::app()->request->getPost('enterpriseCode');
		$meta['input']['partnerCode'] = $partnerCode;
		$meta['input']['enterpriseCode'] = $enterpriseCode;

		try {
			$partner = HUB::getOrganizationByCode($partnerCode);
			$enterprise = HUB::getOrganizationByCode($enterpriseCode);

			$result = HubIdea::removeEnterpriseFromWishlist($partner, $enterprise);
			if ($result) {
				$this->outputSuccess('', $meta);
			} else {
				$this->outputFail($result, $meta);
			}
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetIdeaEnterprisesFromWishlist()
	{
		$meta = array();
		$partnerCode = Yii::app()->request->getPost('partnerCode');
		$meta['input']['partnerCode'] = $partnerCode;

		try {
			$partner = HUB::getOrganizationByCode($partnerCode);

			$tmps = HubIdea::getEnterprisesFromWishlist($partner);
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	//
	// service
	public function actionListServiceBookmarkable()
	{
		$tmps = HUB::listServiceBookmarkable();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionSetServiceBookmarkByUser()
	{
		$meta = array();
		$username = Yii::app()->request->getPost('username');
		$services = Yii::app()->request->getPost('services');
		$meta['input']['username'] = $username;
		$meta['input']['services'] = $services;

		try {
			$user = HUB::getUserByUsername($username);
			// block non active user
			if (!$user->is_active) {
				throw new Exception(sprintf('User %s is not active', $username));
			}
			$tmps = HUB::setServiceBookmarkByUser($user, $services);
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionListServiceBookmarkByUser()
	{
		$meta = array();
		$username = Yii::app()->request->getPost('username');
		$meta['input']['username'] = $username;

		try {
			$user = HUB::getUserByUsername($username);
			// block non active user
			if (!$user->is_active) {
				throw new Exception(sprintf('User %s is not active', $username));
			}
			$tmps = HUB::listServiceBookmarkByUser($user);
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	//
	// actFeed
	public function actionGetUserActFeed()
	{
		$meta = array();

		$jwt = Yii::app()->request->getPost('jwt');
		$year = Yii::app()->request->getPost('year');
		if (empty($year)) {
			$year = date('Y');
		}
		$services = Yii::app()->request->getPost('services');

		$meta['input']['jwt'] = $jwt;
		$meta['input']['year'] = $year;
		$meta['input']['services'] = $services;

		$token = $this->validateJwt($jwt, $meta);
		try {
			$meta['output']['email'] = $token->data->username;

			$user = HUB::getUserByUsername($token->data->username);
			$tmps = HUB::getUserActFeed($user, $year, $services);
			if (!empty($tmps)) {
				foreach ($tmps as $tmp) {
					$result[] = $tmp;
				}
			}

			//print_r($user->toApi());exit;
			$this->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->outputFail($e->getMessage(), $meta);
		}
	}

	public function actionGetSystemActFeed()
	{
		$meta = array();

		$dateStart = Yii::app()->request->getPost('dateStart');
		$dateEnd = Yii::app()->request->getPost('dateEnd');
		$forceRefresh = Yii::app()->request->getPost('forceRefresh');

		$meta['input']['dateStart'] = $dateStart;
		$meta['input']['dateEnd'] = $dateEnd;
		$meta['input']['forceRefresh'] = $forceRefresh;

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'WAPI', 'getSystemActFeed', sha1(json_encode(array('v18', $dateStart, $dateEnd))));

		$result = Yii::app()->cache->get($cacheId);
		if ($result === false || $useCache === false || $forceRefresh) {
			$meta['output']['useCache'] = false;

			$tmps = HUB::getSystemActFeed($dateStart, $dateEnd, $forceRefresh);
			$result['status'] = $tmps['status'];
			$result['msg'] = $tmps['msg'];

			if ($tmps['status'] == 'success') {
				foreach ($tmps['data']['events'] as $event) {
					$result['data']['events'][] = $event->toApi(array('config' => array('mode' => 'private')));
				}
				foreach ($tmps['data']['newOrganizations'] as $newOrganization) {
					$result['data']['newOrganizations'][] = $newOrganization->toApi();
				}
				foreach ($tmps['data']['newOrganizationEmailRequests'] as $newOrganizationEmailRequest) {
					$result['data']['newOrganizationEmailRequests'][] = $newOrganizationEmailRequest->toApi();
				}
				foreach ($tmps['data']['modifiedResources'] as $modifiedResource) {
					$result['data']['modifiedResources'][] = $modifiedResource->toApi();
				}
				foreach ($tmps['data']['newUsers'] as $newUser) {
					$result['data']['newUsers'][] = $newUser->toApi();
				}
				//echo '<pre>';print_r($tmps['data']['upcomingMentorBookings']);exit;
				foreach ($tmps['data']['mentorBookings'] as $mentorProgram) {
					$upcomingBookings = null;
					foreach ($mentorProgram['upcomingBookings'] as $upcomingBooking) {
						$upcomingBookings[] = $upcomingBooking->toApi();
					}
					$result['data']['mentorBookings'][] = array(
						'programName' => $mentorProgram['programName'],
						'upcomingBookings' => $upcomingBookings,
					);
				}
			}

			Yii::app()->cache->set($cacheId, $result, 15 * 60);
		} else {
			$meta['output']['useCache'] = true;
		}

		$result['meta'] = $meta;
		$this->outputPipe($result);
	}

	//
	// master
	public function actionGetAllLegalForms()
	{
		$meta = array();
		$countryCode = Yii::app()->request->getPost('countryCode');
		$meta['input']['countryCode'] = $countryCode;

		$tmps = HUB::getAllActiveLegalForms($countryCode);
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result, $meta);
	}

	public function actionGetAllIndustries()
	{
		$meta = array();

		$tmps = HUB::getAllActiveIndustries();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllProductCategories()
	{
		$meta = array();
		$tmps = HUB::getAllActiveProductCategories();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllImpacts()
	{
		$meta = array();
		$tmps = HUB::getAllActiveImpacts();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllClusters()
	{
		$meta = array();
		$tmps = HUB::getAllActiveClusters();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllPersonas()
	{
		$meta = array();
		$tmps = HUB::getAllActivePersonas();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllStartupStages()
	{
		$meta = array();
		$tmps = HUB::getAllActiveStartupStages();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	public function actionGetAllSdgs()
	{
		$meta = array();
		$tmps = HUB::getAllActiveSdgs();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}
		$this->outputSuccess($result);
	}

	//
	// notify
	/*public function actionGetNotifyReadNow()
	{
		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;

		$data = strval(HUB::getNotifyReadNow($userType, $username));

		$this->outputSuccess($data, $meta);
	}

	public function actionSetNotifyReadNow()
	{
		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;

		$data = strval(HUB::setNotifyReadNow($userType, $username));

		$this->outputSuccess($data, $meta);
	}*/

	public function actionGetNotifies()
	{
		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$currentPage = !empty(Yii::app()->request->getPost('currentPage')) ? Yii::app()->request->getPost('currentPage') : 0;

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['currentPage'] = $currentPage;

		switch ($userType) {
			case 'member':

				$member = Member::username2obj($username);
				if (empty($member)) {
					$this->outputFail(Yii::t('app', 'Member not found'), $meta);
				}
				$receiverId = $member->user_id;
				break;

			case 'admin':

				$admin = Admin::username2obj($username);
				if (empty($admin)) {
					$this->outputFail(Yii::t('app', 'Admin not found'), $meta);
				}
				$receiverId = $admin->user_id;
				break;

			case 'organization':

				$organization = Organization::code2obj($username);
				if (empty($organization)) {
					$this->outputFail(Yii::t('app', 'Organization not found'), $meta);
				}
				$receiverId = $organization->id;
				break;

			default:

				$this->outputFail(Yii::t('app', 'User type is required'), $meta);
		}

		$pagination = array('auto' => false, 'currentPage' => $currentPage);
		$result = HUB::getNotifies($userType, $receiverId, $pagination);
		$meta['output']['totalItemCount'] = $result['totalItemCount'];
		$meta['output']['currentPage'] = $result['pages']->getCurrentPage();
		$meta['output']['limit'] = $result['pages']->getLimit();
		$meta['output']['offset'] = $result['pages']->getOffset();
		$meta['output']['pageCount'] = $result['pages']->getPageCount();
		$meta['output']['pageSize'] = $result['pages']->getPageSize();
		$meta['output']['validateCurrentPage'] = $result['pages']->validateCurrentPage;

		foreach ($result['model'] as $model) {
			$data[] = $model->toApi();
		}
		$this->outputSuccess($data, $meta);
	}

	public function actionNotifyX()
	{
		$meta = array();

		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$title = Yii::app()->request->getPost('title');
		$message = Yii::app()->request->getPost('message');
		$content = Yii::app()->request->getPost('content');
		$priority = Yii::app()->request->getPost('priority');

		if (!isset($priority)) {
			$priority = 3;
		}

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['title'] = $title;
		$meta['input']['message'] = $message;
		$meta['input']['content'] = $content;
		$meta['input']['priority'] = $priority;

		if (empty($message)) {
			$this->outputFail(Yii::t('app', 'Message is required'), $meta);
		}
		$notify = HUB::sendNotify($userType, $username, $message, $title, $content, $priority);
		if (!empty($notify)) {
			$this->outputSuccess($notify->toApi(), $meta);
		}
		$this->outputFail(Yii::t('app', 'Fail to create notification'), $meta);
	}

	public function actionSendEmailNotify()
	{
		$meta = array();

		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$title = Yii::app()->request->getPost('title');
		$content = Yii::app()->request->getPost('content');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['title'] = $title;
		$meta['input']['content'] = $content;

		switch ($userType) {
			case 'member':

				$member = Member::username2obj($username);
				if (empty($member)) {
					$this->outputFail(Yii::t('app', 'Member not found'), $meta);
				}
				$email = $member->getEmail();
				$fullName = $member->user->profile->full_name;
				break;

			case 'admin':

				$admin = Admin::username2obj($username);
				if (empty($admin)) {
					$this->outputFail(Yii::t('app', 'Admin not found'), $meta);
				}
				$email = $admin->getEmail();
				$fullName = $admin->user->profile->full_name;
				break;

			case 'organization':

				$organization = Organization::code2obj($username);
				if (empty($organization)) {
					$this->outputFail(Yii::t('app', 'Organization not found'), $meta);
				}
				$email = $organization->getEmail();
				$fullName = $organization->getFullName();
				break;

			default:

				$this->outputFail(Yii::t('app', 'User type is required'), $meta);
		}

		$tmp = HUB::sendEmail($email, $fullName, $title, $content);
		if ($tmp === true) {
			$this->outputSuccess(array('email' => $email, 'fullName' => $fullName), $meta);
		} else {
			$this->outputFail($tmp, $meta);
		}
	}

	public function actionSendSmsNotify()
	{
		$meta = array();

		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$message = Yii::app()->request->getPost('message');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['message'] = $message;

		switch ($userType) {
			case 'member':

				$member = Member::username2obj($username);
				if (empty($member)) {
					$this->outputFail(Yii::t('app', 'Member not found'), $meta);
				}
				$mobileNo = $member->getMobileNo();
				break;

			case 'admin':

				$admin = Admin::username2obj($username);
				if (empty($admin)) {
					$this->outputFail(Yii::t('app', 'Admin not found'), $meta);
				}
				$mobileNo = $admin->getMobileNo();
				break;

			case 'organization':

				$organization = Organization::code2obj($username);
				if (empty($organization)) {
					$this->outputFail(Yii::t('app', 'Organization not found'), $meta);
				}
				$mobileNo = $organization->getMobileNo();
				break;

			default:

				$this->outputFail(Yii::t('app', 'User type is required'), $meta);
		}

		$tmp = HUB::sendSms($mobileNo, $message);
		if ($tmp->messages[0]->status == 0) {
			$this->outputSuccess($tmp, $meta);
		} else {
			$this->outputFail($tmp, $tmp->messages[0]->errortext, 'fail', $meta);
		}
	}

	//
	// currency
	public function actionConvertCurrency()
	{
		$amount = Yii::app()->request->getPost('amount');
		$fromCurrency = Yii::app()->request->getPost('fromCurrencyCode');
		$toCurrency = Yii::app()->request->getPost('toCurrencyCode');
		$date = Yii::app()->request->getPost('date');

		$meta['input']['amount'] = $amount;
		$meta['input']['fromCurrency'] = $fromCurrency;
		$meta['input']['toCurrency'] = $toCurrency;
		$meta['input']['date'] = $date;

		$return = HUB::convertCurrency($amount, $fromCurrency, $toCurrency, $date);
		$return['meta'] = $meta;
		$this->outputPipe($return);
	}

	//
	// backend
	public function actionSearchBackend()
	{
		$keyword = Yii::app()->request->getPost('keyword');
		$meta['input']['keyword'] = $keyword;

		$return = HUB::searchBackend($keyword);
		$return['meta'] = $meta;
		$this->outputPipe($return);

		// search organization details, email, persona, impact, sdg, country, industry, meta and tags by keyword
		// search individual details and tags by keyword
		// search product details by keyword
		// search event registration details by keyword
		// search event details and tags by keyword
		// search intake details and tags by keyword
		// search resource details, industry and tags by keyword
	}

	/*public function actionSendPushNotify()
	{
		$meta = array();

		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$message = Yii::app()->request->getPost('message');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['message'] = $message;

		switch($userType)
		{
			case 'member':
			{
				$member = Member::username2obj($username);
				if(empty($member)) $this->outputFail(Yii::t('app', 'Member not found'), $meta);
				$primaryDevice = $member->getPrimaryDevice();
				break;
			}
			case 'admin':
			{
				$admin = Admin::username2obj($username);
				if(empty($admin)) $this->outputFail(Yii::t('app', 'Admin not found'), $meta);
				$primaryDevice = $admin->getPrimaryDevice();
				break;
			}
			case 'rider':
			{
				$rider = Rider::username2obj($username);
				if(empty($rider)) $this->outputFail(Yii::t('app', 'Rider not found'), $meta);
				$primaryDevice = $rider->getPrimaryDevice();
				break;
			}
			case 'owner':
			{
				$owner = Owner::username2obj($username);
				if(empty($owner)) $this->outputFail(Yii::t('app', 'Owner not found'), $meta);
				$primaryDevice = $owner->getPrimaryDevice();
				break;
			}
			default:
			{
				$this->outputFail(Yii::t('app', 'User type is required'), $meta);
			}
		}

		$deviceToken = $primaryDevice->device_key;
		$devicePlatform = $primaryDevice->device_platform;
		$tmp = HUB::sendPush($devicePlatform, $deviceToken, $message);
		if($tmp['result'] == 1)
		{
			$this->outputSuccess(array('devicePlatform'=>$devicePlatform, 'deviceToken'=>$deviceToken), $meta);
		}
		else
		{
			$this->outputFail('', $meta);
		}
	}

	public function actionSendPubNubNotify()
	{
		$meta = array();

		$userType = Yii::app()->request->getPost('userType');
		$username = Yii::app()->request->getPost('username');
		$message = Yii::app()->request->getPost('message');

		$meta['input']['userType'] = $userType;
		$meta['input']['username'] = $username;
		$meta['input']['message'] = $message;

		switch($userType)
		{
			case 'member':
			{
				$member = Member::username2obj($username);
				if(empty($member)) $this->outputFail(Yii::t('app', 'Member not found'), $meta);
				$channelId = HUB::getPubNubChannelId($userType, $member->user_id, $member);
				break;
			}
			case 'admin':
			{
				$admin = Admin::username2obj($username);
				if(empty($admin)) $this->outputFail(Yii::t('app', 'Admin not found'), $meta);
				$channelId = HUB::getPubNubChannelId($userType, $admin->user_id, $admin);
				break;
			}
			case 'rider':
			{
				$rider = Rider::username2obj($username);
				if(empty($rider)) $this->outputFail(Yii::t('app', 'Rider not found'), $meta);
				$channelId = HUB::getPubNubChannelId($userType, $rider->user_id, $rider);
				break;
			}
			case 'owner':
			{
				$owner = Owner::username2obj($username);
				if(empty($owner)) $this->outputFail(Yii::t('app', 'Owner not found'), $meta);
				$channelId = HUB::getPubNubChannelId($userType, $owner->id, $owner);
				break;
			}
			default:
			{
				$this->outputFail(Yii::t('app', 'User type is required'), $meta);
			}
		}


		$tmp = HUB::sendPubNub($channelId, $message);
		if($tmp)
		{
			$this->outputSuccess(array(), $meta);
		}
		else
		{
			$this->outputFail('', $meta);
		}
	}*/
}
