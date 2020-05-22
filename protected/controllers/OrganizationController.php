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

class OrganizationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';
	public $customParse = '';

	public function actions()
	{
		return array();
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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array(
					'list', 'view', 'create', 'update', 'admin',
					'addOrganization2Email', 'deleteOrganization2Email', 'getOrganization2Emails', 'toggleOrganization2EmailStatus', 'requestJoinEmail',
					'overview', 'merge', 'getOrganizationNodes', 'doMerge', 'doMergeConfirmed', 'getTagsBackend', 'score', 'join', 'team', 'toggleOrganization2EmailStatusReject'
				),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('housekeeping'),
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'allow',
				'actions' => array(
					'view', 'create', 'update', 'addOrganization2Email', 'deleteOrganization2Email', 'getOrganization2Emails', 'deleteUserOrganization2Email', 'toggleOrganization2EmailStatus', 'requestJoinEmail',
					'removeOrganizationLogo', 'join', 'team', 'toggleOrganization2EmailStatusReject', 'list'
				),
				'users' => array('@'),
			),
			array(
				'allow',
				'actions' => array('select', 'saveForm', 'deleteOrganization2Email', 'deleteUserOrganization2Email', 'join'),
				'users' => array('@'),
				'expression' => '$user->accessCpanel==true',
			),
			array(
				'allow',
				'actions' => array('overview', 'view', 'admin'),
				'users' => array('@'),
				// 'expression' => '$user->isEcosystem==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->activeMenuMain = 'organization';
		$this->layoutParams['enableGlobalSearchBox'] = true;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		$model = $this->loadModel($id);

		if (empty($realm)) {
			$realm = 'backend';
		}
		$this->pageTitle = Yii::t('app', 'View Organization');

		if ($realm == 'cpanel') {
			$this->layout = 'cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->activeMenuCpanel = 'information';
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $model->id;
			$this->pageTitle = Yii::t('app', "View '{OrganizationTitle}'", array('{OrganizationTitle}' => $model->title));
		}

		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$actions = array();
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getOrganizationActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getOrganizationActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeOrganizationViewTabs($model, $realm);

		$this->render('view', array(
			'model' => $model,
			'organization' => $model,
			'actions' => $actions,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($realm = 'backend', $scenario = 'create')
	{
		$organizations['organizations']['approve'] = HUB::getActiveOrganizations(Yii::app()->user->username, 'approve');
		$organizations['organizations']['pending'] = HUB::getActiveOrganizations(Yii::app()->user->username, 'pending');

		if (empty($realm)) {
			$realm = 'backend';
			$this->pageTitle = Yii::t('app', 'Create Organization');
		}

		if ($realm == 'cpanel') {
			$this->layout = 'cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->pageTitle = Yii::t('app', 'Create Organization');
			$this->cpanelMenuInterface = 'cpanelNavOrganization';
			$this->activeMenuCpanel = 'create';
			$this->pageTitle = Yii::t('app', 'Create Organization');
		}

		$model = new Organization;
		$model->scenario = $scenario;

		if (isset($_POST['Organization'])) {
			$model->attributes = $_POST['Organization'];

			$params['organization'] = $_POST['Organization'];
			$params['userEmail'] = Yii::app()->user->username;
			$model = HUB::createOrganization($_POST['Organization']['title'], $params);

			if (!empty($model->id)) {
				$this->redirect(array('view', 'id' => $model->id, 'realm' => $realm));
			} else {
				Notice::page(Yii::t('notice', 'Failed to link data to creator'));
			}
		}

		$this->render('create', array(
			'model' => $model,
			'realm' => $realm,
			'organizations' => $organizations,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $realm = 'backend', $scenario = 'update', $returnUrl = '')
	{
		$model = $this->loadModel($id);

		if (empty($realm)) {
			$realm = 'backend';
		}
		$this->pageTitle = Yii::t('app', 'Update Organization');

		if ($realm == 'cpanel') {
			$this->layout = 'cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->activeMenuCpanel = 'information';
			$this->pageTitle = Yii::t('app', 'Update Organization');
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $model->id;
		}

		$model->scenario = $scenario;

		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Organization'])) {
			$oriModel = clone $model;
			$model->attributes = $_POST['Organization'];
			$model->setLatLongAddress($_POST['Organization']['latlong_address']);

			// convert full address to parts and store
			if (($oriModel->full_address != $model->full_address) && !empty($model->full_address)) {
				$model->resetAddressParts();
			}

			// so m2m still funtion when it is empty
			if (empty($_POST['Organization']['inputIndustries'])) {
				$model->inputIndustries = null;
			}
			if (empty($_POST['Organization']['inputPersonas'])) {
				$model->inputPersonas = null;
			}
			if (empty($_POST['Organization']['inputImpacts'])) {
				$model->inputImpacts = null;
			}
			if (empty($_POST['Organization']['inputSdgs'])) {
				$model->inputSdgs = null;
			}

			$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');

			if ($model->save()) {
				UploadManager::storeImage($model, 'logo', $model->tableName());

				Notice::flash(Yii::t('notice', "{title}' updated successfully", ['{title}' => $model->title]), Notice_SUCCESS);

				$log = Yii::app()->esLog->log(sprintf("updated organization '%s'", $model->title), 'organization', array('trigger' => 'OrgranizationController::actionUpdate', 'model' => 'Organization', 'action' => 'update', 'id' => $model->id, 'organizationId' => $model->id));

				if (!empty($returnUrl)) {
					$this->redirect(urldecode($returnUrl));
				} else {
					$this->redirect(array('view', 'id' => $model->id, 'realm' => $realm));
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
			'organization' => $model,
			'realm' => $realm
		));
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('organization/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList($realm = 'backend')
	{
		if ($realm === 'backend') {
			$dataProvider = new CActiveDataProvider('Organization');
			$dataProvider->pagination->pageSize = 5;
			$dataProvider->pagination->pageVar = 'page';

			$this->render('index', array(
				'dataProvider' => $dataProvider,
				'realm' => $realm,
			));
		}
		if ($realm === 'cpanel') {
			$this->layout = 'cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->pageTitle = Yii::t('app', 'Organization List');
			$this->cpanelMenuInterface = 'cpanelNavOrganization';
			$this->activeMenuCpanel = 'list';

			$model = HUB::getActiveOrganizations(Yii::app()->user->username, 'approve');
			$this->render('index', array(
				'model' => $model,
				'realm' => $realm,
			));
		}
	}

	public function actionTeam($id)
	{
		$model = $this->loadModel($id);

		if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
			$this->redirect(array('/organization/list'));
		}

		$this->layout = 'cpanel';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
		$this->pageTitle = 'Team Members';
		$this->activeMenuCpanel = 'team';
		$this->customParse = $model->id;

		$org2email = HUB::getOrganization2Emails($id);

		$approve = array();
		$reject = array();
		$pending = array();

		foreach ($org2email['model'] as $email) {
			if ($email->status === 'approve') {
				array_push($approve, $email);
			}
			if ($email->status === 'reject') {
				array_push($reject, $email);
			}
			if ($email->status === 'pending') {
				array_push($pending, $email);
			}
		}

		$emails['approve'] = $approve;
		$emails['reject'] = $reject;
		$emails['pending'] = $pending;

		$this->render('team', array('model' => $model, 'emails' => $emails));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->pageTitle = Yii::t('app', 'Manage Organization');

		$model = new Organization('search');
		$model->unsetAttributes();  // clear any default values
		$model->is_active = 1;

		if (isset($_GET['Organization'])) {
			$model->attributes = $_GET['Organization'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionSelect($keyword = '')
	{
		$this->pageTitle = Yii::t('app', 'Select Organization');
		$this->layout = 'cpanel';

		$keyword = $_GET['keyword'];

		$tmps = HUB::getUserOrganizationsCanJoin($keyword, Yii::app()->user->username);

		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi(array('-products', '-impacts', '-sdgs'));
		}

		$model['organizations']['approve'] = HUB::getActiveOrganizations(Yii::app()->user->username, 'approve');
		$model['organizations']['pending'] = HUB::getActiveOrganizations(Yii::app()->user->username, 'pending');

		$this->render('select', array(
			'model' => $model, 'data' => $result
		));
	}

	public function actionJoin()
	{
		$this->layout = 'cpanel';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('app', 'Join Organization');
		$this->cpanelMenuInterface = 'cpanelNavOrganization';
		$this->activeMenuCpanel = 'join';
		$model = HUB::getActiveOrganizations(Yii::app()->user->username, 'pending');
		$this->render('join', array('model' => $model));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organization the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Organization::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionGetOrganization2Emails($organizationId, $Organization2Emails_page = 0, $realm = 'backend')
	{
		$model['realm'] = $realm;
		$model['list'] = HUB::getOrganization2Emails($organizationId, $Organization2Emails_page);

		Yii::app()->clientScript->scriptMap = array('jquery.min.js' => false);
		$this->renderPartial('_getOrganization2Emails', $model, false, true);
	}

	public function actionDeleteOrganization2Email($id, $realm = 'backend', $scenario = 'join')
	{
		$model = HUB::getOrganization2Email($id);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->organization->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$organization = $model->organization;
		$copy = clone $model;
		if ($model->delete()) {
			// notify the email about his access to this organization
			$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($copy);
			HUB::sendEmail($copy->user_email, $copy->user_email, $notifMaker['title'], $notifMaker['content']);

			$log = Yii::app()->esLog->log(sprintf("deleted '%s' access to organization '%s'", $copy->user_email, $copy->organization->title), 'organization', array('trigger' => 'OrgranizationController::actionDeleteOrganization2Email', 'model' => 'Organization', 'action' => 'deleteOrganization2Email', 'id' => $copy->organization->id, 'organizationId' => $copy->organization->id));

			if ($realm == 'cpanel') {
				Notice::flash(Yii::t('notice', "Successfully revoke request from email '{email}' to join '{organizationTitle}'", ['{email}' => $copy->user_email, '{organizationTitle}' => $copy->organization->title]), Notice_SUCCESS);
			} else {
				// same user
				Notice::flash(Yii::t('notice', "Successfully revoke '{email}' access to '{organizationTitle}'", ['{email}' => $copy->user_email, '{organizationTitle}' => $copy->organization->title]), Notice_SUCCESS);
			}

			if ($copy->user_email == Yii::app()->user->username) {
				if ($realm === 'backend') {
					$this->redirect(array('organization/select', 'realm' => $realm));
				}
				if ($realm === 'cpanel') {
					$this->redirect(array('organization/join'));
				}
			}

			if ($realm === 'backend') {
				$this->redirect(array('organization/view', 'id' => $organization->id, 'realm' => $realm));
			}
			if ($realm === 'cpanel') {
				if ($scenario === 'join') {
					$this->redirect(array('join', 'realm' => $realm));
				}
				if ($scenario === 'team') {
					$this->redirect(array('team', 'id' => $model->organization->id, 'realm' => $realm));
				}
			}
		}
	}

	public function actionDeleteUserOrganization2Email($organizationID, $userEmail, $realm = 'cpanel')
	{
		$result = HUB::getOrganization2EmailUserID($organizationID, $userEmail);

		Notice::page(Yii::t('notice', 'You are about to remove your access request to the organization. Click OK to continue.'), Notice_WARNING, array(
			'url' => $this->createUrl('organization/deleteOrganization2Email', array('id' => $result, 'realm' => $realm)), 'cancelUrl' => ($realm === 'backend') ? $this->createUrl('organization/select') : $this->createUrl('organization/join')
		));
	}

	public function actionAddOrganization2Email($organizationId, $realm = 'backend', $scenario = 'join')
	{
		$organization = $this->loadModel($organizationId);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$organization->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$model = new Organization2Email;

		if (isset($_POST['Organization2Email'])) {
			$model->attributes = $_POST['Organization2Email'];
			$model->organization_id = $organizationId;
			$model->user_email = trim($model->user_email);
			$model->status = 'approve';

			if ($model->save()) {
				// notify the email about his access to this organization
				$notifMaker = NotifyMaker::user_hub_approveEmailAccess($model);
				HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);

				Notice::flash(Yii::t('notice', "Successfully added email '{email}' to organization '{organizationTitle}'", ['{email}' => $model->user_email, '{organizationTitle}' => $model->organization->title]), Notice_SUCCESS);

				$log = Yii::app()->esLog->log(sprintf("added '%s' access to organization '%s'", $model->user_email, $organization->title), 'organization', array('trigger' => 'OrgranizationController::actionAddOrganization2Email', 'model' => 'Organization', 'action' => 'addOrganization2Email', 'id' => $organization->id, 'organizationId' => $organization->id));
			} else {
				Notice::flash(Yii::t('notice', "Failed to add email '{email}' to organization '{organizationTitle}'", ['{email}' => $model->user_email, '{organizationTitle}' => $model->organization->title]), Notice_ERROR);
			}
		}

		if ($scenario === 'join') {
			$this->redirect(array('view', 'id' => $model->organization_id, 'realm' => $realm));
		}
		if ($scenario === 'team') {
			$this->redirect(array('team', 'id' => $model->organization->id, 'realm' => $realm));
		}
	}

	public function actionToggleOrganization2EmailStatus($id, $realm = 'backend', $scenario = 'join')
	{
		$model = HUB::getOrganization2Email($id);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->organization->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		/*if($model->status == 'reject') $model->status = 'approve';
		else if($model->status == 'approve') $model->status = 'reject';
		else if($model->status == 'pending') $model->status = 'approve';*/

		$model->status = $model->getNextToggleStatus();

		if ($model->save()) {
			if ($model->status == 'reject') {
				// notify the email about his access to this organization
				$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($model);
				HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);
			} elseif ($model->status == 'approve') {
				// notify the email about his access to this organization
				$notifMaker = NotifyMaker::user_hub_approveEmailAccess($model);
				HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);
			}

			Notice::flash(Yii::t('notice', "Successfully changed status to '{status}'", ['{status}' => $model->formatEnumStatus($model->status)]), Notice_SUCCESS);
		}

		if ($scenario === 'join') {
			$this->redirect(array('view', 'id' => $model->organization_id, 'realm' => $realm));
		}

		if ($scenario === 'team') {
			$this->redirect(array('team', 'id' => $model->organization->id, 'realm' => $realm));
		}
	}

	public function actionToggleOrganization2EmailStatusReject($id)
	{
		$model = HUB::getOrganization2Email($id);

		if (!Yii::app()->user->accessBackend) {
			if (!$model->organization->canAccessByUserEmail(Yii::app()->user->username)) {
				$this->redirect(array('/organization/list'));
			}
		}

		$model->status = 'reject';

		if ($model->save()) {
			$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($model);
			HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);

			Notice::flash(Yii::t('notice', "Successfully changed status to '{status}'", ['{status}' => $model->formatEnumStatus($model->status)]), Notice_SUCCESS);
		}

		$this->redirect(array('team', 'id' => $model->organization->id, 'realm' => 'cpanel'));
	}

	public function actionRequestJoinEmail($organizationId, $email, $realm = 'cpanel')
	{
		$model = new Organization2Email;
		$model->organization_id = $organizationId;
		$model->user_email = $email;

		//echo $model->organization->hasUserEmail($email);exit;
		if ($model->organization->hasUserEmail($email)) {
			if ($model->organization->canAccessByUserEmail($email)) {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is already linked up with '{organizationTitle}'.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_ERROR);
			} else {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is either blocked or access not granted yet by '{organizationTitle}'.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_ERROR);
			}
		} else {
			if ($model->save()) {
				Notice::flash(Yii::t('notice', "Successfully added request from email '{email}' to join '{organizationTitle}'.", ['{email}' => $email, '{organizationTitle}' => $model->organization->title]), Notice_SUCCESS);
			}
		}

		if ($realm === 'backend') {
			$this->redirect(array('select', 'id' => $model->organization_id, 'realm' => $realm));
		}

		if ($realm === 'cpanel') {
			$this->redirect(array('organization/join'));
		}
	}

	public function actionOverview()
	{
		$stat['general']['totalOrganizations'] = Organization::model()->isActive()->countByAttributes(array());

		$personas = Persona::model()->isActive()->findAll(array('order' => 'title ASC'));
		foreach ($personas as $persona) {
			$stat['persona'][$persona->title] = Yii::app()->db->createCommand(sprintf('SELECT COUNT(o.id) FROM organization as o JOIN persona2organization as p2o ON p2o.organization_id=o.id JOIN persona as p ON p2o.persona_id=p.id WHERE o.is_active=1 AND p.id=%s', $persona->id))->queryScalar();
		}

		$industries = Industry::model()->isActive()->findAll(array('order' => 'title ASC'));
		foreach ($industries as $industry) {
			$stat['industry'][$industry->title] = Yii::app()->db->createCommand(sprintf('SELECT COUNT(o.id) FROM organization as o JOIN industry2organization as i2o ON i2o.organization_id=o.id JOIN industry as i ON i2o.industry_id=i.id WHERE o.is_active=1 AND i.id=%s', $industry->id))->queryScalar();
		}

		$impacts = Impact::model()->isActive()->findAll(array('order' => 'title ASC'));
		foreach ($impacts as $impact) {
			$stat['impact'][$impact->title] = Yii::app()->db->createCommand(sprintf('SELECT COUNT(o.id) FROM organization as o JOIN impact2organization as i2o ON i2o.organization_id=o.id JOIN impact as i ON i2o.impact_id=i.id WHERE o.is_active=1 AND i.id=%s', $impact->id))->queryScalar();
		}

		$sdgs = Sdg::model()->isActive()->findAll(array('order' => 'title ASC'));
		foreach ($sdgs as $sdg) {
			$stat['sdg'][$sdg->title] = Yii::app()->db->createCommand(sprintf('SELECT COUNT(o.id) FROM organization as o JOIN sdg2organization as s2o ON s2o.organization_id=o.id JOIN sdg as s ON s2o.sdg_id=s.id WHERE o.is_active=1 AND s.id=%s', $sdg->id))->queryScalar();
		}

		// country
		$countries = Yii::app()->db->createCommand(sprintf('SELECT c.printable_name as title, COUNT(o.id) as total FROM `organization` as o RIGHT JOIN country as c ON o.address_country_code=c.code WHERE o.is_active=1 GROUP BY c.code ORDER BY total DESC'))->queryAll();
		foreach ($countries as $country) {
			$stat['country'][$country['title']] = $country['total'];
		}

		// quality
		// organization without any email access
		$stat['quality']['noEmailAccess'] = Yii::app()->db->createCommand(sprintf('select COUNT(o.id) from organization o left outer join organization2email o2e on o2e.organization_id = o.id where o.is_active=1 AND o2e.id is null'))->queryScalar();
		// organization without logo
		$stat['quality']['noLogo'] = Yii::app()->db->createCommand(sprintf('SELECT COUNT(o.id) FROM organization as o WHERE o.is_active=1 AND (o.image_logo="%s")', Organization::getDefaultImageLogo()))->queryScalar();
		// organization without one_liner
		$stat['quality']['noOneLiner'] = Yii::app()->db->createCommand('SELECT COUNT(o.id) FROM organization as o WHERE o.is_active=1 AND (o.text_oneliner IS NULL OR o.text_oneliner="")')->queryScalar();
		// organization without address_country_code
		$stat['quality']['noAddressCountryCode'] = Yii::app()->db->createCommand('SELECT COUNT(o.id) FROM organization as o WHERE o.is_active=1 AND (o.address_country_code IS NULL OR o.address_country_code="")')->queryScalar();
		// organization without any persona
		$stat['quality']['noPersona'] = Yii::app()->db->createCommand(sprintf('select COUNT(o.id) from organization o left outer join persona2organization p2o on p2o.organization_id = o.id where o.is_active=1 AND p2o.organization_id is null'))->queryScalar();

		// organization without any industry
		$stat['quality']['noIndustry'] = Yii::app()->db->createCommand(sprintf('select COUNT(o.id) from organization o left outer join industry2organization i2o on i2o.organization_id = o.id where o.is_active=1 AND i2o.organization_id is null'))->queryScalar();

		// organization without any impact
		$stat['quality']['noImpact'] = Yii::app()->db->createCommand(sprintf('select COUNT(o.id) from organization o left outer join impact2organization i2o on i2o.organization_id = o.id where o.is_active=1 AND i2o.organization_id is null'))->queryScalar();

		// organization without any sdg
		$stat['quality']['noSdg'] = Yii::app()->db->createCommand(sprintf('select COUNT(o.id) from organization o left outer join sdg2organization s2o on s2o.organization_id = o.id where o.is_active=1 AND s2o.organization_id is null'))->queryScalar();

		$this->render('overview', array('stat' => $stat));
	}

	public function actionMerge($sourceKeyword = '', $targetKeyword = '')
	{
		$this->pageTitle = Yii::t('app', 'Merge Organizations');

		$suggestions = Yii::app()->db->createCommand('SELECT * FROM (select count(*) as total, title, left(organization.title, 10) as r from organization WHERE is_active=1 GROUP BY r ORDER BY total DESC) AS a WHERE a.total>1')->queryAll();
		//echo '<pre>';print_r($suggestions);exit;

		$this->render('merge', array('targetKeyword' => $targetKeyword, 'sourceKeyword' => $sourceKeyword, 'suggestions' => $suggestions));
	}

	public function actionDoMerge($sourceKeyword, $targetKeyword)
	{
		if (is_numeric($sourceKeyword)) {
			$source = Organization::model()->findByAttributes(array('id' => $sourceKeyword));
		} else {
			$source = Organization::model()->findByAttributes(array('title' => $sourceKeyword));
		}

		if (is_numeric($targetKeyword)) {
			$target = Organization::model()->findByAttributes(array('id' => $targetKeyword));
		} else {
			$target = Organization::model()->findByAttributes(array('title' => $targetKeyword));
		}

		Notice::page(Yii::t('backend', "Are you sure to merge all data from '{source}' into '{target}'? This action is NOT REVERSIBLE. '{source}' will be deactivated after the process.", ['{source}' => $source->title, '{target}' => $target->title]), Notice_WARNING, array(
			'url' => $this->createUrl('organization/doMergeConfirmed', array('target' => $target->id, 'source' => $source->id)),
			'cancelUrl' => $this->createUrl('organization/merge', array('targetKeyword' => $target->title, 'sourceKeyword' => $source->title))
		));
	}

	public function actionDoMergeConfirmed($source, $target)
	{
		$success = false;
		try {
			$source = Organization::model()->findByAttributes(array('id' => $source));

			$target = Organization::model()->findByAttributes(array('id' => $target));

			$result = HUB::doOrganizationsMerge($source, $target);
			$success = true;
		} catch (Exception $e) {
			$success = false;
			$exceptionMessage = $e->getMessage();
		}

		if ($success) {
			/* save history of merging */
			HUB::createOrganizationMergeHistory($source, $target);

			Notice::page(Yii::t('backend', "Successfully merged '{source}' into '{target}'", ['{source}' => $source->title, '{target}' => $target->title]), Notice_SUCCESS, array('url' => $this->createUrl('organization/view', array('id' => $target->id))));
		} else {
			Notice::page(Yii::t('backend', "Failed to merge '{source}' into '{target}' due to error: {error}", ['{source}' => $source->title, '{target}' => $target->title, '{error}' => $exceptionMessage]), Notice_ERROR, array('url' => $this->createUrl('organization/merge', array('targetKeyword' => $target->title, 'sourceKeyword' => $source->title))));
		}
	}

	public function actionGetOrganizationNodes($keyword)
	{
		if (is_numeric($keyword)) {
			$model = Organization::model()->findByAttributes(array('id' => $keyword));
		} else {
			$model = Organization::model()->findByAttributes(array('title' => $keyword));
		}

		if (!empty($model)) {
			echo $this->renderPartial('_getOrganizationNodes', array('model' => $model));
		} else {
			echo sprintf("'%s' not found", $keyword);
		}
	}

	public function actionHousekeeping($offset = 0)
	{
		$limit = 500;

		$criteria = new CDbCriteria();
		$criteria->together = false;
		$criteria->condition = 'is_active=1';
		$criteria->offset = $offset;
		$criteria->limit = $limit;

		$total = Organization::model()->count($criteria);
		//$total = 15;

		if ($offset + $limit <= $total + $limit) {
			$organizations = Organization::model()->findAll($criteria);
			//$tmp = HubOrganization::getOrganizationAllActive(1);
			//$organizations = $tmp['items'];
			foreach ($organizations as $organization) {
				$organization->save();
			}
		}

		if ($offset + $limit <= $total) {
			$urlNext = Yii::app()->createUrl('/organization/housekeeping', array('offset' => $offset + $limit));

			Notice::page(Yii::t('backend', 'Housekeeping for {offset}-{limit} companies done', array('{offset}' => $offset + 1, '{limit}' => $offset + $limit)), Notice_INFO, array('url' => $urlNext, 'urlLabel' => "Next {$limit}"));
		} else {
			$urlDone = Yii::app()->createUrl('/organization/admin');

			Notice::page(Yii::t('backend', 'Housekeeping done', array('{offset}' => $offset + 1, '{limit}' => $limit)), Notice_INFO, array('url' => $urlDone));
		}
	}

	public function actionGetTagsBackend()
	{
		header('Content-type: application/json');

		$tmps = Tag::model()->findAll(array('select' => 'name', 'order' => 'name ASC'));
		foreach ($tmps as $t) {
			$result[] = $t->name;
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}

	public function actionRemoveOrganizationLogo()
	{
		if (isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] == 1) {
			$id = $_POST['id'];
			$image_logo = $_POST['image_logo'];
			$image_href = $_POST['image_href'];

			Organization::model()->updateByPk($id, array('image_logo' => null));
			$model = Organization::model()->findByPk($id, array('select' => 'image_logo'));

			// Remote file url
			$remoteFile = $image_href;

			// Initialize cURL
			$ch = curl_init($remoteFile);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			// Check the response code
			// if exist then remove file
			if ($responseCode == 200) {
				// code remove here
				$resultAws = Yii::app()->s3->delete(Yii::app()->params['s3Bucket'], $image_logo);
			}

			echo Html::activeThumb($model, 'image_logo');
			Yii::app()->end();
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organization $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'organization-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getOrganizationViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
			$tabs['organization'][] = array(
				'key' => 'individual',
				'title' => 'Individual',
				'viewPath' => 'views.individualOrganization.backend._view-organization-individual'
			);
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['organization'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta'
			);
		}

		return $tabs;
	}

	/**
	 * Shows S3 sore of particular startup.
	 */
	public function actionScore($id)
	{
		// Get name of organization
		$this->pageTitle = Yii::t('app', 'View Organization');
		$model = $this->loadModel($id);
		$this->pageTitle = Yii::t('app', "View '{OrganizationTitle}' Score", array('{OrganizationTitle}' => $model->title));
		$org_name = $model->title;

		$application = HubAtas::getApplicationFromStartupName($org_name);
		$application_id = $application['map_application_id'];
		$this->render('score', array(
			'model' => $model,
			'organization' => $model,
			'application_id' => $application_id
		));
		// Get startup_id
		// Get map_application id
		// $this->render('score', array());
	}
}
