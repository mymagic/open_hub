<?php

class BackendController extends Controller
{
	public $layout = 'backend';

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
					'overview', 'syncToResource', 'syncToResourceConfirmed',
				),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
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
		$this->activeMenuCpanel = 'resource';
		$this->activeMenuMain = 'resource';
	}

	public function actionIndex()
	{
		$this->redirect(array('overview'));
	}

	public function actionOverview()
	{
		// todo: cache these
		$stat['general']['totalResources'] = Resource::model()->countByAttributes(array());
		$stat['general']['totalPublishedResources'] = Resource::model()->countByAttributes(array('is_active' => 1));
		$stat['general']['totalFeaturedResources'] = Resource::model()->countByAttributes(array('is_featured' => 1, 'is_active' => 1));

		$stat['general']['totalOrganizations'] = Yii::app()->db->createCommand('SELECT COUNT(DISTINCT(organization_id)) FROM resource2organization')->queryScalar();

		// category
		$tmps = HubResource::getTypefors();
		foreach ($tmps as $tmpKey => $tmpValues) {
			$count = Yii::app()->db->createCommand(sprintf("SELECT COUNT(r.id) FROM resource as r, resource_category as c, resource2resource_category as r2c WHERE r2c.resource_category_id=c.id AND r2c.resource_id=r.id AND c.typefor='%s'", $tmpKey))->queryScalar();

			$countPublished = Yii::app()->db->createCommand(sprintf("SELECT COUNT(r.id) FROM resource as r, resource_category as c, resource2resource_category as r2c WHERE r2c.resource_category_id=c.id AND r2c.resource_id=r.id AND c.typefor='%s' AND r.is_active=1", $tmpKey))->queryScalar();

			$childs = null;
			$childCategories = ResourceCategory::model()->findAllByAttributes(array('typefor' => $tmpKey));
			foreach ($childCategories as $childCat) {
				$countChildCat = Yii::app()->db->createCommand(sprintf("SELECT COUNT(r.id) FROM resource as r, resource_category as c, resource2resource_category as r2c WHERE r2c.resource_category_id=c.id AND r2c.resource_id=r.id AND c.id='%s'", $childCat->id))->queryScalar();

				$publishedChildCat = Yii::app()->db->createCommand(sprintf("SELECT COUNT(r.id) FROM resource as r, resource_category as c, resource2resource_category as r2c WHERE r2c.resource_category_id=c.id AND r2c.resource_id=r.id AND c.id='%s' AND r.is_active=1", $childCat->id))->queryScalar();

				$childs[$childCat->slug] = array(
					'title' => $childCat->title,
					'count' => $countChildCat,
					'published' => $publishedChildCat,
				);
			}

			$stat['categories'][$tmpKey] = array(
				'title' => $tmpValues,
				'count' => $count,
				'published' => $countPublished,
				'childs' => $childs,
			);
		}

		//print_r($stat);exit;
		$this->render('overview', array('stat' => $stat));
	}

	public function actionSync2Event($dateStart = '', $dateEnd = '')
	{
		Notice::page(Yii::t('backend', 'You are about to sync all active uncancelled event records to Resource module. Click OK to continue.'), Notice_WARNING, array(
			'url' => $this->createUrl('//resource/backend/sync2EventConfirmed', array('dateStart' => $dateStart, 'dateEnd' => $dateEnd)),
			'cancelUrl' => $this->createUrl('//event/admin'),
		));
	}

	public function actionSync2EventConfirmed($dateStart = '', $dateEnd = '')
	{
		$result = HUB::syncEventToResource($dateStart, $dateEnd);
		if ($result['status'] == 'success') {
			Notice::page($result['msg'], Notice_SUCCESS, array('url' => $this->createUrl('//event/admin')));
		} else {
			Notice::page($result['msg'], Notice_ERROR);
		}

		Yii::app()->end();
	}
}
