<?php

class JourneyModule extends WebModule
{
	public $emailTeam;
	public $defaultController = 'backend';
	private $_assetsUrl;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->setComponents(array(
			'request' => array(
				'class' => 'HttpRequest',
				'enableCsrfValidation' => false,
			),
		));

		// import the module-level models and components
		$this->setImport(array(
			'journey.models.*',
			'journey.components.*',
		));
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('mentor.assets'));
		}

		return $this->_assetsUrl;
	}

	public function getDashboardViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['journey'][] = array(
					'key' => 'organization',
					'title' => 'Organization',
					'viewPath' => 'modules.journey.views.backend._view-dashboard-organization'
				);
				$tabs['journey'][] = array(
					'key' => 'member',
					'title' => 'Member',
					'viewPath' => 'modules.journey.views.backend._view-dashboard-member'
				);
				$tabs['journey'][] = array(
					'key' => 'event',
					'title' => 'Event',
					'viewPath' => 'modules.journey.views.backend._view-dashboard-event'
				);
			}
		}

		return $tabs;
	}

	//
	// organization
	public function getOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['journey'][] = array(
					'key' => 'event',
					'title' => 'Event',
					'viewPath' => 'modules.journey.views.backend._view-organization-journey',
				);
			}
			// if (Yii::app()->user->isSuperAdmin || (Yii::app()->user->isAdmin && Yii::app()->user->isSensitiveDataAdmin)) {
			if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'admin']]) && Yii::app()->user->getState('accessSensitiveData')) {
				$tabs['journey'][] = array(
					'key' => 'funding',
					'title' => 'Funding',
					'viewPath' => 'modules.journey.views.backend._view-organization-funding',
				);
				$tabs['journey'][] = array(
					'key' => 'revenue',
					'title' => 'Revenue',
					'viewPath' => 'modules.journey.views.backend._view-organization-revenue',
				);
				$tabs['journey'][] = array(
					'key' => 'status',
					'title' => 'Status',
					'viewPath' => 'modules.journey.views.backend._view-organization-status',
				);
			}
		}

		return $tabs;
	}

	public function getOrganizationActions($model, $realm = 'backend')
	{
		$actions['individual'][] = array(
			'visual' => 'primary',
			'label' => 'Add New',
			'title' => 'Add a new individual to this company.',
			'url' => Yii::app()->controller->createUrl('/individualOrganization/create', array('organizationCode' => $model->code, 'realm' => $realm)),
		);

		$actions['funding'][] = array(
			'visual' => 'primary',
			'label' => 'Add New',
			'title' => 'Add a new funding raised record to this company.',
			'url' => Yii::app()->controller->createUrl('/organizationFunding/create', array('organization_id' => $model->id, 'realm' => $realm)),
		);
		$actions['revenue'][] = array(
			'visual' => 'primary',
			'label' => 'Add New',
			'title' => 'Add a new revenue record to this company.',
			'url' => Yii::app()->controller->createUrl('/organizationRevenue/create', array('organization_id' => $model->id, 'realm' => $realm)),
		);
		$actions['status'][] = array(
			'visual' => 'primary',
			'label' => 'Add New',
			'title' => 'Add a new status record to this company.',
			'url' => Yii::app()->controller->createUrl('/organizationStatus/create', array('organization_id' => $model->id, 'realm' => $realm)),
		);
		$actions['milestone'][] = array(
			'visual' => 'primary',
			'label' => 'Add New',
			'title' => 'Add a new milestone record to this company.',
			'url' => Yii::app()->controller->createUrl('/milestone/create', array('organization_id' => $model->id, 'realm' => $realm)),
		);

		return $actions;
	}

	public function getOrganizationActFeed($organization, $year)
	{
		return null;
	}

	//
	// individual
	public function getIndividualViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['journey'][] = array(
					'key' => 'event',
					'title' => 'Event',
					'viewPath' => 'modules.journey.views.backend._view-individual-journey',
				);
			}
		}

		return $tabs;
	}

	public function getIndividualActions($model, $realm = 'backend')
	{
		if ($realm == 'backend') {
			$actions['organization'][] = array(
				'visual' => 'primary',
				'label' => 'Link Company',
				'title' => 'Add a new company to this individual.',
				'url' => Yii::app()->controller->createUrl('/individualOrganization/create', array('individualId' => $model->id, 'realm' => $realm)),
			);
		}

		return $actions;
	}

	public function getIndividualActFeed($individual, $year)
	{
		return null;
	}

	//
	// user
	public function getUserActFeed($user, $year)
	{
		$return = array();

		// todo: check timezone issue
		$timestampStart = mktime(0, 0, 0, 1, 1, $year);
		$timestampEnd = mktime(0, 0, 0, 1, 1, $year + 1);
		$now = HUB::now();

		// filter all event by email to this year
		$eventRegistrations = HUB::getAllEventRegistrationsByEmail($user, $timestampStart, $timestampEnd);

		if (!empty($eventRegistrations)) {
			foreach ($eventRegistrations as $er) {
				$timestampEventStart = $er->event->date_started;
				$isPast = $timestampEventStart < $now ? true : false;

				// for past event
				if ($isPast) {
					// attended
					if ($er->is_attended) {
						$msg = Yii::t('journey', "You have attended '{eventName}' with registration code #{regCode} at {eventAt}.", array('{eventName}' => $er->event->title, '{eventAt}' => $er->event->at, '{regCode}' => $er->registration_code));
					}
					// not sure is attended or not
					else {
						$msg = Yii::t('journey', "You have registered for '{eventName}' with registration code #{regCode} started at {eventAt}.", array('{eventName}' => $er->event->title, '{eventAt}' => $er->event->at, '{regCode}' => $er->registration_code));
					}
				} else {
					$msg = Yii::t('journey', "You are scheduled to attend '{eventName}' with registration code #{regCode} at {eventAt}.", array('{eventName}' => $er->event->title, '{eventAt}' => $er->event->at, '{regCode}' => $er->registration_code));
				}

				$return[] = array('service' => 'journey', 'timestamp' => $timestampEventStart, 'date' => date('r', $timestampEventStart), 'msg' => $msg, 'actionLabel' => '', 'actionUrl' => '');
			}
		}

		return $return;
	}

	public function getNavItems($controller, $forInterface)
	{
		switch ($forInterface) {
			case 'backendNavService':

				return array(
					array(
						'label' => Yii::t('app', 'Journey'), 'url' => array('/journey/backend/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true,
						'active' => $controller->activeMenuMain == 'journey' ? true : false,
					),
				);

				break;

			case 'backendNavDev':

				return array(
					array('label' => Yii::t('app', 'Junk'), 'url' => array('/junk/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true)
				);

				break;
		}
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		//
		// individual
		$searchModel = new Individual('search');
		$result['individual'] = $searchModel->searchAdvance($searchFormModel->keyword);

		//
		// organization
		$searchModel = new Organization('search');
		$result['organization'] = $searchModel->searchAdvance($searchFormModel->keyword);

		//
		// event
		$searchModel = new Event('search');
		$result['event'] = $searchModel->searchAdvance($searchFormModel->keyword);
		$result['event']->sort->defaultOrder = 't.is_active DESC, t.title ASC';

		//
		// eventRegistration
		$searchModel = new EventRegistration('search');
		$result['eventRegistration'] = $searchModel->searchAdvance($searchFormModel->keyword);

		//
		// tag
		$searchModel = new Tag('search');
		$result['tag'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'organization' => array(
				'tabLabel' => Yii::t('backend', 'Company'),
				'itemViewPath' => 'application.modules.journey.views.backend._view-organization',
				'result' => $result['organization'],
			),
			'individual' => array(
				'tabLabel' => Yii::t('backend', 'Individual'),
				'itemViewPath' => 'application.modules.journey.views.backend._view-individual',
				'result' => $result['individual'],
			),
			'event' => array(
				'tabLabel' => Yii::t('backend', 'Event'),
				'itemViewPath' => 'application.modules.journey.views.backend._view-event',
				'result' => $result['event'],
			),
			'eventRegistration' => array(
				'tabLabel' => Yii::t('backend', 'Event Registration'),
				'itemViewPath' => 'application.modules.journey.views.backend._view-eventRegistration',
				'result' => $result['eventRegistration'],
			),
			'tag' => array(
				'tabLabel' => Yii::t('backend', 'Tag'),
				'itemViewPath' => 'application.modules.journey.views.backend._view-tag',
				'result' => $result['tag'],
			),
		);
	}
}
