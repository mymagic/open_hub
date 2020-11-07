<?php

class FrontendController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'view', 'organization', 'getResourcesByOrg', 'viewBySlug', 'go', 'test'),
				'users' => array('*'),
			),
			array('allow',
				'actions' => array('add', 'createResource', 'createOrganization', 'requestJoinEmail'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->layout = 'frontend';
		$this->activeMenuCpanel = 'resource';
		$this->activeMenuMain = 'resource';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
	}

	public function beforeAction($view)
	{
		if (!empty(Yii::app()->request->getParam('brand'))) {
			$this->layoutParams['brand'] = 'psk';
		}

		return true;
	}

	public function actions()
	{
		return array(
		);
	}

	public function getCommonData()
	{
		return array(
			'personas' => HubResource::getPersonas(),
			'startupStage' => HubResource::getStartupStages(),
			'industries' => HubResource::getIndustries(),
			'categories' => HubResource::getCategories(),
			'locations' => HubResource::getGeofocuses(),
		);
	}

	public function actionTest()
	{
		$this->render('test');
	}

	public function actionIndex()
	{
		$alldata = array();

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$persona = '';
		$stage = '';
		$industry = '';
		$location = '';
		$cat = '';

		if (isset($_GET['keyword'])) {
			$keyword = Yii::app()->request->getParam('keyword');
		}
		if (isset($_GET['persona'])) {
			$persona = implode(',', Yii::app()->request->getParam('persona'));
		}
		if (isset($_GET['stage'])) {
			$stage = implode(',', Yii::app()->request->getParam('stage'));
		}
		if (isset($_GET['industry'])) {
			$industry = implode(',', Yii::app()->request->getParam('industry'));
		}
		if (isset($_GET['cat'])) {
			$cat = implode(',', Yii::app()->request->getParam('cat'));
		}
		if (isset($_GET['location'])) {
			$location = implode(',', Yii::app()->request->getParam('location'));
		}

		if (!empty($keyword) || !empty($persona) || !empty($stage) || !empty($industry) || !empty($cat) || !empty($location)) {
			$page = isset($_GET['page']) ? Yii::app()->request->getParam('page') : 1;

			$tmps = HubResource::getAllActive(
				$page,
				array(
					'keyword' => $keyword,
					'persona' => $persona,
					'stage' => $stage,
					'industry' => $industry,
					'location' => $location,
					'cat' => $cat,
				)
			);

			if (!empty($tmps['items'])) {
				foreach ($tmps['items'] as $tmp) {
					$result['data'][] = $tmp;
				}
			}

			$result['countPageItems'] = $tmps['countPageItems'];
			$result['limit'] = $tmps['limit'];
			$result['filters'] = $tmps['filters'];
			$result['totalItems'] = $tmps['totalItems'];
			$result['totalPages'] = $tmps['totalPages'];
		}

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$hero = Embed::getByCode('resource-directory-index');
		$tmpHighlightedOrganizations = Setting::code2value('resource-organizationHighlight');
		if (!empty($tmpHighlightedOrganizations)) {
			$tmpHighlightedOrganizations = explode(',', $tmpHighlightedOrganizations);
			foreach ($tmpHighlightedOrganizations as $tmpHighlightedOrganization) {
				$highlightedOrganizations[] = Organization::model()->findByPk($tmpHighlightedOrganization);
			}
		}

		$popup = Embed::getByCode('resource-directory-popup');

		$viewFile = 'index';
		if ($this->layoutParams['brand'] == 'psk') {
			$viewFile = 'index-psk';
		}

		$this->render($viewFile, array(
			'model' => $result,
			'countPageItems' => $tmps['countPageItems'],
			'limit' => $tmps['limit'],
			'totalItems' => $tmps['totalItems'],
			'totalPages' => $tmps['totalPages'],
			'page' => $page,
			'hero' => $hero,
			'popup' => $popup,
			'highlightedOrganizations' => $highlightedOrganizations,
		));
	}

	public function actionViewBySlug($slug)
	{
		$resource = HubResource::getBySlug($slug);
		if ($resource == null || !$resource->is_active || $resource->is_blocked) {
			Notice::page(Yii::t('notice', 'Resource not found'));
		}

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$this->render('view', array('model' => $resource, 'data' => json_encode($result)));
	}

	public function actionView($id)
	{
		$resource = HubResource::getResource($id);
		if ($resource == null || !$resource->is_active || $resource->is_blocked) {
			Notice::page(Yii::t('notice', 'Resource not found'));
		}

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$this->render('view', array('model' => $resource, 'data' => json_encode($result)));
	}

	public function actionOrganization($id)
	{
		$organization = HUB::getOrganization($id);
		if ($organization == null) {
			Notice::page(Yii::t('notice', 'Organization not found'));
		}

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$this->render('organization', array('model' => $organization, 'resources' => $organization->activeResources));
	}

	public function actionCategories()
	{
		$categories = HubResource::getCategories();

		$this->render('student', array('categories' => $categories));
		$this->render('startup', array('categories' => $categories));
	}

	public function actionAdd($keyword = '')
	{
		if (!Yii::app()->getModule('resource')->allowUserAddResource) {
			Notice::page(Yii::t('resource', 'User is not allow to add new resources as per setting'), Notice_INFO);
		}

		$tmps = HUB::getUserOrganizationsCanJoin($keyword, HUB::getSessionUsername());

		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi(array('-products', '-impacts'));
		}

		$model['organizations']['approve'] = HUB::getActiveOrganizations(HUB::getSessionUsername(), 'approve');
		$model['organizations']['pending'] = HUB::getActiveOrganizations(HUB::getSessionUsername(), 'pending');

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		if (!empty($_GET)) {
			if (isset($_GET['keyword'])) {
				$keyword = $_GET['keyword'];
			}
			if (isset($_GET['persona'])) {
				$persona = implode(',', $_GET['persona']);
			}
			if (isset($_GET['stage'])) {
				$stage = implode(',', $_GET['stage']);
			}
			if (isset($_GET['industry'])) {
				$industry = implode(',', $_GET['industry']);
			}
			if (isset($_GET['cat'])) {
				$cat = implode(',', $_GET['cat']);
			}
			if (isset($_GET['location'])) {
				$location = implode(',', $_GET['location']);
			}

			$page = isset($_GET['page']) ? $_GET['page'] : 1;

			$tmps = HubResource::getAllActive(
				$page,
				array(
					'persona' => $persona,
					'stage' => $stage,
					'industry' => $industry,
					'location' => $location,
					'cat' => $cat,
				)
			);

			if (!empty($tmps['items'])) {
				foreach ($tmps['items'] as $tmp) {
					$result['data'][] = $tmp->toApi();
				}
			}

			$result['countPageItems'] = $tmps['countPageItems'];
			$result['limit'] = $tmps['limit'];
			$result['filters'] = $tmps['filters'];
			$result['totalItems'] = $tmps['totalItems'];
			$result['totalPages'] = $tmps['totalPages'];
		}

		$this->mixPanelTrack('resource.add', array('user' => $this->user->username));
		$this->piwikTrack('resource', 'add', array('user' => $this->user->username));

		$this->render('add', array('model' => $model, 'data' => $result, 'personas' => $personas, 'categories' => $categories, 'startupStage' => $startupStages, 'industries' => $industries, 'locations' => $locations, 'data' => json_encode($result)));
	}

	public function actionRequestJoinEmail($organizationId, $email)
	{
		$model = new Organization2Email();
		$model->organization_id = $organizationId;
		$model->user_email = $email;

		//echo $model->organization->hasUserEmail($email);exit;
		if ($model->organization->hasUserEmail($email)) {
			if ($model->organization->canAccessByUserEmail($email)) {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is already linked up with '{organizationTitle}'.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_ERROR);
			} else {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is blocked by '{organizationTitle}'.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_ERROR);
			}
		} else {
			if ($model->save()) {
				$this->mixPanelTrack('resource.requestJoinOrg', array('user' => $model->user_email, 'organization_id' => $model->organization_id, 'organization_title' => $model->organization->title));
				$this->piwikTrack('resource', 'requestJoinOrg', array('user' => $model->user_email, 'organization_id' => $model->organization_id, 'organization_title' => $model->organization->title));

				Notice::flash(Yii::t('notice', "Successfully added request to join '{organizationTitle}'. You can add new resource once your request has been accepted.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_SUCCESS);
			}
		}

		$this->redirect(array('add', 'id' => $model->organization_id));
	}

	public function actionCreateOrganization($scenario = 'create')
	{
		$this->pageTitle = Yii::t('app', 'Create Organization');

		$model = new Organization();
		$model->scenario = $scenario;

		if (isset($_POST['Organization'])) {
			$model->attributes = $_POST['Organization'];

			$params['organization'] = $_POST['Organization'];
			$params['userEmail'] = HUB::getSessionUsername();
			$model = HUB::createOrganization($_POST['Organization']['title'], $params);

			if (!empty($model->id)) {
				Notice::flash(Yii::t('app', "{organizationTitle} has been successfully added. You can add manage this company in your <a class='btn btn-xs btn-primary' href='{url}'>Dashboard</a>", ['{organizationTitle}' => $model->title, '{url}' => Yii::app()->createUrl('/organization/view', array('id' => $model->id, 'realm' => 'cpanel'))]), Notice_SUCCESS);

				$this->mixPanelTrack('resource.createOrganization', array('organization_id' => $model->id, 'organization_title' => $model->title));
				$this->piwikTrack('resource', 'createOrganization', array('organization_id' => $model->id, 'organization_title' => $model->title));

				$this->redirect(array('createResource', 'id' => $model->id));
			}
		}

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$this->render('createOrganization', array(
			'model' => $model, 'data' => $result, 'personas' => $personas, 'categories' => $categories, 'startupStage' => $startupStages, 'industries' => $industries, 'locations' => $locations, 'data' => json_encode($result), ));
	}

	public function actionCreateResource($id)
	{
		//if(empty($realm)) $realm='backend';
		//if($realm == 'cpanel') $this->layout = 'cpanel';
		$this->pageTitle = Yii::t('app', 'Create Resource');
		$this->activeSubMenuCpanel = 'resource-create';

		$model = new Resource();

		if (!empty($id)) {
			$organization = Organization::model()->findByPk($id);
		}
		$email = HUB::getSessionUsername();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Resource'])) {
			$model->attributes = $_POST['Resource'];

			/*
			 * since _en & _ms dont appear in the form, assigned the value from title & html_content
			 * it is because beforeValidate assign the title with title_en and html_content with html_content_en
			 */
			$model->title_en = $model->title_ms = $model->title;
			$model->html_content_en = $model->html_content_ms = $model->html_content;

			if (!empty($organization->id)) {
				$model->inputOrganizations = array($organization->id);
			}

			if (!empty($_POST['Resource']['latlong_address'])) {
				$model->setLatLongAddress($_POST['Resource']['latlong_address']);
			}

			$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');
			// $model->latlong_address = null;
			// var_dump($model->validate(), $model->getErrors());
			if ($model->save()) {
				$realm = 'cpanel';
				UploadManager::storeImage($model, 'logo', $model->tableName());
				// 'url'=>array('/resource/resource/adminByOrganization', )

				$url = Yii::app()->createUrl('/resource/resource/adminByOrganization', array('organization_id' => $organization->id, 'realm' => $realm));

				$log = Yii::app()->esLog->log(sprintf("created resource '%s'", $model->title), 'resource', array('trigger' => 'FrontendController::actionCreateResource', 'model' => 'Resource', 'action' => 'createResource', 'id' => $model->id));

				Notice::flash(Yii::t('notice', "A new resource has been successfully added by {organizationTitle}. You can add manage this resource in your <a class='btn btn-xs btn-primary' href='$url'>Dashboard</a>", ['{organizationTitle}' => $organization->title]), Notice_SUCCESS);
				$this->mixPanelTrack('resource.createResource', array('organization_title' => $organization->title, 'resource_id' => $model->id, 'resource_title' => $model->title));
				$this->piwikTrack('resource', 'createResource', array('organization_title' => $organization->title, 'resource_id' => $model->id, 'resource_title' => $model->title));
				$this->redirect(array('view', 'id' => $model->id, 'organization_id' => $id));
			}

			// clear unwanted error messages
			$model->clearErrors('html_content_en');
			$model->clearErrors('title_en');
			$model->clearErrors('slug');
		}

		list($personas, $startupStages, $industries, $categories, $locations) = array_values(self::getCommonData());

		$this->layoutParams['resourceFilters'] = array(
			'personas' => $personas,
			'startupStage' => $startupStages,
			'industries' => $industries,
			'categories' => $categories,
			'locations' => $locations,
		);

		$this->render('createResource', array(
			'model' => $model,
			'organization' => $organization, 'data' => $result, 'personas' => $personas, 'categories' => $categories, 'startupStage' => $startupStages, 'industries' => $industries, 'locations' => $locations, 'data' => json_encode($result), ));
	}

	public function actionGo($id)
	{
		$goToWebsite = HubResource::getResource($id);

		if ($goToWebsite->url_website == null) {
			Notice::page('Website not found');
		}
		$this->redirect($goToWebsite->url_website);
	}

	public function actionTestFlashNotice()
	{
		Notice::flash('testing');
		Notice::flash('testing', Notice_SUCCESS);
		$this->render('index');
	}
}
