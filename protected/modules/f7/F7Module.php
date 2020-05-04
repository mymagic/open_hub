<?php

class F7Module extends WebModule
{
	private $_assetsUrl;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'f7.models.*',
			'f7.components.*',
		));
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('f7.assets'));
		}

		return $this->_assetsUrl;
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			if (true == Yii::app()->params['dev']) {
				Yii::app()->assetManager->forceCopy = true;
			}

			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}

	public function getOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['f7'][] = array(
					'key' => 'f7',
					'title' => 'F7',
					'viewPath' => 'modules.f7.views.backend._view-organization-formSubmissions',
				);
			}
		}

		return $tabs;
	}

	public function getOrganizationActions($model, $realm = 'backend')
	{
		if ($realm == 'backend') {
		} elseif ($realm == 'cpanel') {
		}

		return $actions;
	}

	public function getMemberViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['f7'][] = array(
					'key' => 'f7',
					'title' => 'F7',
					'viewPath' => 'modules.f7.views.backend._view-member-formSubmissions',
				);
			}
		}

		return $tabs;
	}

	public function getUserActFeed($user, $year)
	{
		$return = array();

		// todo: check timezone issue
		$timestampStart = mktime(0, 0, 0, 1, 1, $year);
		$timestampEnd = mktime(0, 0, 0, 1, 1, $year + 1);

		try {
			$formSubmissions = HubForm::getFormSubmissions($user);
			if (!empty($formSubmissions)) {
				foreach ($formSubmissions as $formSubmission) {
					// filter all booking by email to this year
					if ($formSubmission->date_added >= $timestampStart && $formSubmission->date_added < $timestampEnd) {
						if (!empty($formSubmission->form->getIntake())) {
							$msg = Yii::t('f7', "Your submission #{submissionId} for '{intakeTitle} \ {formTitle}' is in {status} mode.", array('{submissionId}' => $formSubmission->id, '{formTitle}' => $formSubmission->form->title, '{intakeTitle}' => $formSubmission->form->getIntake()->title, '{status}' => $formSubmission->formatEnumStatus($formSubmission->status)));
						} else {
							$msg = Yii::t('f7', "Your submission #{submissionId} for '{formTitle}' is in {status} mode.", array('{submissionId}' => $formSubmission->id, '{formTitle}' => $formSubmission->form->title, '{status}' => $formSubmission->formatEnumStatus($formSubmission->status)));
						}

						$return[] = array('service' => 'f7', 'timestamp' => $formSubmission->date_added, 'date' => date('r', $formSubmission->date_added), 'msg' => $msg, 'actionLabel' => 'View Detail', 'actionUrl' => Yii::app()->createAbsoluteUrl('/f7/publish/index', array('slug' => $formSubmission->form->slug, 'sid' => $formSubmission->id)));
					}
				}
			}
		} catch (Exception $e) {
			return null;
		}

		return $return;
	}

	public function getNavItems($controller, $forInterface)
	{
		switch ($forInterface) {
			case 'backendNavService':

				return array(
					array(
						'label' => Yii::t('backend', 'F7'), 'url' => '#',
						// 'visible' => Yii::app()->user->getState('accessBackend') == true && !Yii::app()->user->getState('isEcosystem'),
						'visible' => (
							Yii::app()->user->getState('accessBackend') == true &&
							!HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'ecosystem'], 'checkAccess' => true])
							) && (
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'intake', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']]) ||
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'form', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']]) ||
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'submission', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']])
						),
						'active' => $controller->activeMenuMain == 'f7' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							//array('label'=>Yii::t('app', 'Overview'), 'url'=>array('/f7/overview'), 'visible'=>Yii::app()->user->getState('accessBackend')==true),
							array(
								'label' => Yii::t('app', 'Intake'), 'url' => array('/f7/intake/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true,
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'intake', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']]),
							),
							array(
								'label' => Yii::t('app', 'Form'), 'url' => array('/f7/form/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true,
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'form', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']])
							),
							array(
								'label' => Yii::t('app', 'Submission') . ' <span class="label label-warning">dev</span>', 'url' => array('/f7/submission/admin'),
								// 'visible' => Yii::app()->user->getState('isDeveloper'),
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'submission', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'f7']])
							),
						),
					),
				);

				break;
		}
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		$searchModel = new Form('search');
		$result['form'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'form' => array(
				'tabLabel' => Yii::t('backend', 'Form'),
				'itemViewPath' => 'application.modules.f7.views.backend._view-form-advanceSearch',
				'result' => $result['form'],
			),
			/*
			'intake' => array(
				'tabLabel' => Yii::t('backend', 'Intake'),
				'itemViewPath' => 'application.modules.f7.views.backend._view-intake-advanceSearch',
				'result' => $result['intake'],
			),
			'formSubmission' => array(
				'tabLabel' => Yii::t('backend', 'Form Submission'),
				'itemViewPath' => 'application.modules.f7.views.backend._view-formSubmission-advanceSearch',
				'result' => $result['formSubmission'],
			),*/
		);
	}

	public function getDashboardViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['f7'][] = array(
					'key' => 'form',
					'title' => 'Form',
					'viewPath' => 'modules.f7.views.backend._view-dashboard-form'
				);
			}
		}

		return $tabs;
	}
}
