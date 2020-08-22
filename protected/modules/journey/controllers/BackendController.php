<?php

class BackendController extends Controller
{
	public $layout = 'layouts.backend';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array(
					'admin', 'search', 'searchJourney',
					'getEventSystemActFeed', 'getOrganizationSystemActFeed', 'getOrganizationEmailRequestSystemActFeed', 'getMemberSystemActFeed',
				),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true || $user->isEcosystem==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->activeMenuCpanel = 'journey';
		$this->activeMenuMain = 'journey';
	}

	public function actionAdmin()
	{
		$this->redirect(array('searchJourney'));
	}

	public function actionSearch($keyword)
	{
		$this->pageTitle = Yii::t('app', 'Advance Search');
		$model['form'] = new SearchForm();
		$model['form']->keyword = $keyword;

		$log = Yii::app()->esLog->log(sprintf("searched '%s'", $keyword), 'journey', array('trigger' => 'BackendController::actionSearch', 'model' => '', 'action' => '', 'id' => ''));

		$result = array();
		if (!empty($model['form']->keyword) && $model['form']->validate()) {
			$modules = YeeModule::getActiveParsableModules();
			foreach ($modules as $moduleKey => $moduleParams) {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getBackendAdvanceSearch')) {
					$result = CMap::mergeArray($result, Yii::app()->getModule($moduleKey)->getBackendAdvanceSearch($this, $model['form']));
				}
			}
		} else {
			Notice::page(Yii::t('backend', 'Keyword not found'));
		}

		$this->render('search', array('model' => $model, 'result' => $result, 'showSearchBox' => false));
	}

	public function actionSearchJourney($fullName = '', $email = '', $mobileNo = '')
	{
		$this->pageTitle = Yii::t('app', 'Search Journey');
		$model['form'] = new SearchForm();

		if (!empty($fullName)) {
			$_POST['SearchForm']['fullName'] = $model['form']->fullName = $fullName;
		}
		if (!empty($email)) {
			$_POST['SearchForm']['email'] = $model['form']->email = $email;
		}
		if (!empty($mobileNo)) {
			$_POST['SearchForm']['mobileNo'] = $model['form']->mobileNo = $mobileNo;
		}

		if (isset($_POST['SearchForm'])) {
			$model['form']->attributes = $_POST['SearchForm'];
			if ($model['form']->validate()) {
				$exactMatch = false;
				if (!empty($model['form']->email)) {
					$model['searchMode'] = 'email';
					$model['form']->fullName = $model['form']->mobileNo = '';

					$sqlProfile = sprintf("SELECT full_name, email, phone FROM `event_registration` WHERE `email` LIKE '%%%s%%' GROUP BY email ORDER BY `email` DESC", trim($model['form']->email));

					$sql = sprintf("SELECT e.* FROM event as e LEFT JOIN event_registration as er ON er.event_code=e.code WHERE er.email='%s' AND e.is_active=1 GROUP BY e.id ORDER BY e.date_started DESC", trim($model['form']->email));

					$log = Yii::app()->esLog->log(sprintf("searched email '%s'", $model['form']->email), 'journey', array('trigger' => 'BackendController::actionSearchJourney', 'model' => '', 'action' => '', 'id' => ''));
				} elseif (!empty($model['form']->mobileNo)) {
					$model['searchMode'] = 'mobileNo';
					$model['form']->email = $model['form']->fullName = '';

					$sqlProfile = sprintf("SELECT full_name, email, phone FROM `event_registration` WHERE `phone` LIKE '%%%s%%' GROUP BY phone ORDER BY `phone` DESC", trim($model['form']->mobileNo));

					$sql = sprintf("SELECT e.* FROM event as e LEFT JOIN event_registration as er ON er.event_code=e.code WHERE er.phone LIKE '%%%s%%' AND e.is_active=1 GROUP BY e.id ORDER BY e.date_started DESC", trim($model['form']->mobileNo));

					$log = Yii::app()->esLog->log(sprintf("searched mobile number '%s'", $model['form']->mobileNo), 'journey', array('trigger' => 'BackendController::actionSearchJourney', 'model' => '', 'action' => '', 'id' => ''));
				} elseif (!empty($model['form']->fullName)) {
					$model['searchMode'] = 'fullName';
					$model['form']->email = $model['form']->mobileNo = '';

					$log = Yii::app()->esLog->log(sprintf("searched name '%s'", $model['form']->fullName), 'journey', array('trigger' => 'BackendController::actionSearchJourney', 'model' => '', 'action' => '', 'id' => ''));

					if (substr($model['form']->fullName, 0, 1) == "'") {
						$exactMatch = true;
					}

					if (!$exactMatch) {
						$sqlProfile = sprintf("SELECT full_name, email, phone FROM `event_registration` WHERE `full_name` LIKE '%%%s%%' GROUP BY full_name ORDER BY `full_name` DESC", trim($model['form']->fullName));

						$sql = sprintf("SELECT e.* FROM event as e LEFT JOIN event_registration as er ON er.event_code=e.code WHERE er.full_name LIKE '%%%s%%' AND e.is_active=1 GROUP BY e.id ORDER BY e.date_started DESC", trim($model['form']->fullName));
					} else {
						$sql = sprintf("SELECT e.* FROM event as e LEFT JOIN event_registration as er ON er.event_code=e.code WHERE er.full_name LIKE '%s' AND e.is_active=1 GROUP BY e.id ORDER BY e.date_started DESC", str_replace("'", '', trim($model['form']->fullName)));
					}
				} else {
					Notice::page(Yii::t('notice', 'Invalid Input!'));
				}

				$model['events'] = Event::model()->findAllBySql($sql);

				if (!empty($sqlProfile)) {
					$model['profiles'] = EventRegistration::model()->findAllBySql($sqlProfile);
				}
			}
		}

		$this->render('searchJourney', array('model' => $model));
	}

	public function actionGetEventSystemActFeed($dateStart, $dateEnd, $page = 1, $forceRefresh = 0)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getEventSystemActFeed',
			[
				'form_params' => [
					'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'page' => $page, 'forceRefresh' => $forceRefresh,
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		header('Content-type: application/json');
		echo $response->getBody();
	}

	public function actionGetOrganizationSystemActFeed($dateStart, $dateEnd, $page = 1, $forceRefresh = 0)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getOrganizationSystemActFeed',
			[
				'form_params' => [
					'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'page' => $page, 'forceRefresh' => $forceRefresh,
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		header('Content-type: application/json');
		echo $response->getBody();
	}

	public function actionGetMemberSystemActFeed($dateStart, $dateEnd, $page = 1, $forceRefresh = 0)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getMemberSystemActFeed',
			[
				'form_params' => [
					'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'page' => $page, 'forceRefresh' => $forceRefresh,
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		header('Content-type: application/json');
		echo $response->getBody();
	}
}
