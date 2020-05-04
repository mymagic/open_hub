<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class HUB extends Component
{
	public static function now()
	{
		return time();
	}

	public static function renderPartial($viewPath, $data, $return)
	{
		// if web
		if (isset(Yii::app()->controller)) {
			return Yii::app()->controller->renderPartial($viewPath, $data, $return);
		}
		// if console
		else {
			//$viewPath = sprintf('%s%s.php', Yii::app()->basePath.DIRECTORY_SEPARATOR.'views', $viewPath);
			$viewPath = sprintf('%s%s.php', Yii::getPathOfAlias('views'), $viewPath);

			return CConsoleCommand::renderFile($viewPath, $data, $return);
		}
	}

	// path here is the yii version like application.modules.xyz.views.organization._abc
	public static function isViewExists($path)
	{
		return is_file(Yii::getPathOfAlias($path) . '.php');
	}

	//
	// user
	public static function getUserByUsername($username)
	{
		$model = User::model()->username2obj($username);
		if ($model === null) {
			throw new CHttpException(404, 'The requested user does not exist.');
		}

		return $model;
	}

	public function createLocalMember($email, $fullName, $signupType = 'default')
	{
		$newPassword = ysUtil::generateRandomPassword();

		$model = new Member('create');
		$model->username = $email;
		$model->full_name = $fullName;

		$user = new User('create');
		$user->profile = new Profile('create');

		$transaction = Yii::app()->db->beginTransaction();

		try {
			// create user
			$user->username = $email;
			$user->password = $newPassword;
			$user->signup_type = $signupType;
			$user->signup_ip = Yii::app()->request->userHostAddress;
			$user->is_active = 1;
			//Since we are deactivating and not removing account.
			//$user->hash_email = self::Encrypt($email);

			$result = $user->save();

			// create profile
			if ($result == true) {
				$user->profile->user_id = $user->id;
				$user->profile->full_name = $fullName;
				$user->profile->image_avatar = 'uploads/profile/avatar.default.jpg';

				$result = $user->profile->save();

				if ($result == true) {
					$member = new Member();
					$member->user_id = $user->id;
					$member->username = $user->username;
					$member->date_joined = time();
					$result = $member->save();
				} else {
					throw new Exception(Yii::t('app', 'Failed to save profile into database'));
				}
			} else {
				throw new Exception(Yii::t('app', 'Failed to save user into database '));
			}

			$log = Yii::app()->esLog->log('created user account', 'user', array('trigger' => 'HUB::createLocalMember', 'model' => 'User', 'action' => 'create', 'id' => $user->id), $user->username);

			$transaction->commit();
		} catch (Exception $e) {
			$exceptionMessage = $e->getMessage();
			$result = false;
			$transaction->rollBack();
		}

		// successfully finish the registration step of the subscription process
		return $result;
	}

	public static function getOrCreateUser($username, $extra = array())
	{
		$user = User::model()->username2obj($username);
		if ($user === null) {
			if (self::createLocalMember($username, $extra['fullname'])) {
				$user = User::model()->username2obj($username);
			}
		}

		return $user;
	}

	// create request to create user data download pack
	// return request
	public static function requestUserDataDownload($user, $format = 'html')
	{
		$now = self::now();

		$request = new Request();
		$request->user_id = $user->id;
		$request->type_code = 'generateUserDataDownload';
		$request->title = sprintf("Request to generate user data for download by '%s' on %s", $user->username, Html::formatDateTime($now, 'standard', 'standard'));
		$request->status = 'pending';
		$request->jsonArray_data['format'] = $format;
		$request->save();

		return $request;
	}

	// create download pack
	/*
		user profile
		session
		role
		charge
		events joined
		form submission
		bookmarked services
		milestone
		organization
	*/
	public static function createUserDataDownload($user, $format)
	{
		$status = 'fail';
		$msg = 'Unknown Error';

		$apiUser = $user->toApi();

		// user
		$json['userProfile']['username'] = array('label' => $user->getAttributeLabel('username'), 'value' => $apiUser['username']);
		$json['userProfile']['fDateActivated'] = array('label' => $user->getAttributeLabel('dateActivated'), 'value' => $apiUser['fDateActivated']);
		$json['userProfile']['signupType'] = array('label' => $user->getAttributeLabel('signup_type'), 'value' => $apiUser['signupType']);
		$json['userProfile']['fDateLastLogin'] = array('label' => $user->getAttributeLabel('date_last_login'), 'value' => $apiUser['fDateLastLogin']);

		// profile
		$json['userProfile']['fullName'] = array('label' => $user->profile->getAttributeLabel('full_name'), 'value' => $apiUser['profile']['fullName']);
		$json['userProfile']['gender'] = array('label' => $user->profile->getAttributeLabel('gender'), 'value' => $apiUser['profile']['gender']);
		$json['userProfile']['language'] = array('label' => $user->profile->getAttributeLabel('language'), 'value' => $apiUser['profile']['language']);
		$json['userProfile']['currency'] = array('label' => $user->profile->getAttributeLabel('currency'), 'value' => $apiUser['profile']['currency']);
		$json['userProfile']['imageAvatarUrl'] = array('label' => $user->profile->getAttributeLabel('image_avatar'), 'value' => $apiUser['profile']['imageAvatarUrl']);

		// role
		$roles = $user->roles;
		if (!empty($roles)) {
			foreach ($roles as $role) {
				$json['roles'][] = array(
					'title' => array('label' => $role->getAttributeLabel('title'), 'value' => $role->title),
				);
			}
		}

		// charge

		// milestone

		// mentor

		// events joined
		for ($year = date('Y'); $year >= 2014; --$year) {
			$timestampStart = mktime(0, 0, 0, 1, 1, $year);
			$timestampEnd = mktime(0, 0, 0, 1, 1, $year + 1);

			// filter all event by email to this year
			$eventRegistrations = self::getAllEventRegistrationsByEmail($user, $timestampStart, $timestampEnd);

			foreach ($eventRegistrations as $er) {
				$json['eventRegistrations'][$year][] = array(
					'title' => array('label' => $er->event->getAttributeLabel('title'), 'value' => $er->event->title),
					'at' => array('label' => $er->event->getAttributeLabel('at'), 'value' => $er->event->at),
					'dateStarted' => array('label' => $er->event->getAttributeLabel('date_started'), 'value' => $er->event->renderDateStarted()),
					'dateEnded' => array('label' => $er->event->getAttributeLabel('date_ended'), 'value' => $er->event->renderDateEnded()),
					'isAttended' => array('label' => $er->getAttributeLabel('is_attended'), 'value' => $er->is_attended),
				);
			}
		}

		// form submission
		// todo: modularize
		$formSubmissions = HubForm::getFormSubmissions($user);
		foreach ($formSubmissions as $formSubmission) {
			$tmp = null;
			$tmp['formTitle'] = array('label' => $formSubmission->form->getIntake()->getAttributeLabel('title'), 'value' => '');
			if ($formSubmission->form->hasIntake()) {
				$tmp['formTitle']['value'] .= $formSubmission->form->getIntake()->title;
			}
			$tmp['formTitle']['value'] .= ' \\ ' . $formSubmission->form->title;

			$tmp['code'] = array('label' => $formSubmission->getAttributeLabel('code'), 'value' => $formSubmission->code);
			$tmp['status'] = array('label' => $formSubmission->getAttributeLabel('status'), 'value' => $formSubmission->formatEnumStatus($formSubmission->status));
			$tmp['stage'] = array('label' => $formSubmission->getAttributeLabel('stage'), 'value' => $formSubmission->formatEnumStage($formSubmission->stage));
			$tmp['dateSubmitted'] = array('label' => $formSubmission->getAttributeLabel('date_submitted'), 'value' => $formSubmission->renderDateSubmitted());
			$tmp['jsonData'] = array('label' => $formSubmission->getAttributeLabel('json_data'), 'value' => $formSubmission->jsonArray_data);
			$tmp['htmlData'] = array('label' => $formSubmission->getAttributeLabel('json_data'), 'value' => $formSubmission->renderSimpleFormattedHtml());

			$json['formSubmissions'][] = $tmp;
		}

		// bookmarked services
		$bookmarks = self::listServiceBookmarkByUser($user);
		if (!empty($bookmarks)) {
			foreach ($bookmarks as $bookmark) {
				$json['services'][] = array(
					'title' => array('label' => $bookmark->service->getAttributeLabel('title'), 'value' => $bookmark->service->title),
				);
			}
		}

		// organization
		$organizations = self::getUserOrganizations($user->username);
		if (!empty($organizations)) {
			foreach ($organizations as $organization) {
				if ($organization->is_active) {
					$json['organizations'][] = array(
						'title' => array('label' => $organization->getAttributeLabel('title'), 'value' => $organization->title),
						'emailContact' => array('label' => $organization->getAttributeLabel('email_contact'), 'value' => $organization->email_contact),
						'textOneliner' => array('label' => $organization->getAttributeLabel('text_oneliner'), 'value' => $organization->text_oneliner),
						'urlWebsite' => array('label' => $organization->getAttributeLabel('url_website'), 'value' => $organization->url_website),
					);
				}
			}
		}

		// activity feed
		for ($year = date('Y'); $year > 2014; --$year) {
			$tmps = HUB::getUserActFeed($user, $year, '*');
			$tmps2 = null;
			foreach ($tmps as $tmp) {
				//group by date
				$date = date('d F Y, l', strtotime($tmp['date']));
				$time = date('h:ia', strtotime($tmp['date']));
				$tmps2[$date][$time][] = $tmp;
			}
			// krsort($result);
			//foreach($tmps2 as $time=>$timeline) {ksort($tmps2[$time]);}

			//echo '<pre>';print_r($tmps2);exit;
			$json['actFeeds'][$year] = $tmps2;
		}

		// echo '<pre>'; print_r($json['actFeeds']); exit;
		//print_r($json);exit;
		//
		if ($format == 'json') {
			$buffer = json_encode($json);
		} else {
			// convert json to html
			// use self::renderPartial so it work in cli environment
			$buffer = self::renderPartial('/request/_createUserDataDownload', array('json' => $json), true);
			// return $buffer;
		}

		// store locally in temp folder
		$secret = sha1(rand(0, 99999999) . time());
		$content = $buffer;
		$uploadFolderName = 'userDataPack';
		$saveFileName = $fileName = sprintf('%s.%s.%s.%s', $user->id, self::now(), $secret, $format);
		$filePath = DIRECTORY_SEPARATOR .
			trim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) .
			DIRECTORY_SEPARATOR .
			ltrim($fileName, DIRECTORY_SEPARATOR);

		file_put_contents($filePath, $content);

		// store the file permanently
		if (Yii::app()->params['storageMode'] == 's3') {
			$mimeType = ysUtil::getMimeType($filePath);
			$pathInAWS = sprintf('uploads/%s/%s', $uploadFolderName, $saveFileName);
			$resultAws = Yii::app()->s3->upload(
				$filePath,
				$pathInAWS,
				Yii::app()->params['s3Bucket'],
				array(),
				array('Content-Type' => $mimeType)
			);

			if ($resultAws) {
				unlink($filePath);
				$status = 'success';
				$msg = '';
			}
		}
		// if using local as storage
		else {
			//$modelFileFile->saveAs(sprintf($uploadPath.DIRECTORY_SEPARATOR.'%s', $saveFileName));
		}

		// return the file url
		return array(
			'status' => $status,
			'msg' => $msg,
			'data' => array(
				'path' => $pathInAWS,
				'url' => StorageHelper::getUrl($pathInAWS),
			),
		);
	}

	// only those 100% generated will be include in the list here
	public static function listUserDataDownload($user)
	{
		$requests = Request::model()->findAll(array('condition' => 'user_id=:userId AND type_code=:typeCode AND status=:status', 'params' => array(':typeCode' => 'generateUserDataDownload', ':status' => 'success', ':userId' => $user->id), 'order' => 'id DESC'));

		return $requests;
	}

	// return the request that user is generating (status: pending or processing)
	public static function getUserGeneratingDataDownloadRequest($user)
	{
		$requests = Request::model()->findAll('user_id=:userId AND type_code=:typeCode AND (status=:status OR status=:status2)', array(':userId' => $user->id, ':typeCode' => 'generateUserDataDownload', ':status' => 'pending', ':status2' => 'processing'));

		return $requests;
	}

	public static function getAllPendingDataDownloadRequest()
	{
		$requests = Request::model()->findAll('type_code=:typeCode AND (status=:status)', array(':typeCode' => 'generateUserDataDownload', ':status' => 'pending'));

		return $requests;
	}

	// pass in the request id of 'generateUserDataDownload' which is in 'pending' status
	public static function processUserDataDownloadRequest($id)
	{
		$request = Request::model()->findByPk($id);
		//if($request->type_code != 'generateUserDataDownload' || $request->status != 'pending')
		if ($request->type_code != 'generateUserDataDownload') {
			throw new Exception('Unqualified request to process');
		}

		try {
			$request->status = 'processing';
			$request->jsonArray_data->dateProcessed = self::now();
			$request->save(false);

			$result = self::createUserDataDownload($request->user, $request->jsonArray_data->format);
			//print_r($result);
			if ($result['status'] == 'success' && !empty($result) && $result['status'] == 'success' && !empty($result['data']['url'])) {
				$request->jsonArray_data->generationResult = $result;

				// todo: send notification email to user
				// notify user about his request has completed and send link to download this file
				$notifMaker = NotifyMaker::member_user_dataDownloadRequestDone($request, $result);

				if (self::sendEmail($request->user->username, $request->user->profile->full_name, $notifMaker['title'], $notifMaker['content'])) {
					$request->status = 'success';
					$request->save(false);
				}
			} else {
				$request->status = 'pending';
				$request->save(false);
			}
		} catch (Exception $e) {
			$request->status = 'pending';
			$request->jsonArray_data->generationResult = 'Exception captured: ' . $e->getMessage();
			$request->save(false);
		}

		return $request;
	}

	//
	//cpanel
	//

	public static function cpanelNavItems($controller, $forInterface)
	{
		return HubCpanel::cpanelNavItems($controller, $forInterface);
	}

	//
	// organization
	public static function getOrCreateOrganization($title, $params)
	{
		return HubOrganization::getOrCreateOrganization($title, $params);
	}

	public static function createOrganization($title, $params)
	{
		return HubOrganization::createOrganization($title, $params);
	}

	public static function getOrganization($id)
	{
		return HubOrganization::getOrganization($id);
	}

	public static function getOrganizationByCode($code)
	{
		return HubOrganization::getOrganizationByCode($code);
	}

	public static function getUserOrganizations($email)
	{
		return HubOrganization::getUserOrganizations($email);
	}

	public static function getOrganizations($email, $status = 'approve')
	{
		return HubOrganization::getOrganizations($email, $status);
	}

	public static function getActiveOrganizations($email, $status = 'approve')
	{
		return HubOrganization::getActiveOrganizations($email, $status);
	}

	public static function getOrganizationAllActive($page = '', $filter = '', $limitPerPage = 10)
	{
		// todo: implement cache
		if ($limitPerPage > 30) {
			$limitPerPage = 30;
		}
		$limit = $limitPerPage * $page;
		$offset = ($page - 1) * $limitPerPage;
		$bufferFilter = 'o.is_active=1';
		$filters = array();

		$slugTitleArray = [
			'personas' => self::getOrganizationPersonas(true),
			'industries' => self::getOrganizationIndustries(true),
		];

		// do cache
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getOrganizationAllActive', sha1(json_encode(array('v1', $page, $filter, $limitPerPage))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			if (!empty($filter) && is_array($filter)) {
				// searchTitle
				// filter out unwanted characters for security purpose
				if (!empty($filter['searchTitle'])) {
					$filterSearchTitles = array_map('trim', explode(',', $filter['searchTitle']));
					$bufferSubFilter = '';
					foreach ($filterSearchTitles as $keyword) {
						$bufferSubFilter .= sprintf("o.title LIKE '%%%s%%' OR ", $keyword);
					}
					$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
					$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				}

				// searchAlpha
				if (!empty($filter['searchAlpha'])) {
					$filterSearchAlpha = $filter['searchAlpha'];

					if ($filterSearchAlpha == '0-9') {
						if (empty($filter['searchTitle'])) {
							$bufferSubFilter .= sprintf("o.title REGEXP '^[%s]'", $filterSearchAlpha);
						} else {
							$bufferSubFilter .= sprintf(" AND o.title REGEXP '^[%s]'", $filterSearchAlpha);
						}
					} else {
						if (empty($filter['searchTitle'])) {
							$bufferSubFilter .= sprintf("o.title LIKE '%s%%'", $filterSearchAlpha);
						} else {
							$bufferSubFilter .= sprintf(" AND o.title LIKE '%s%%'", $filterSearchAlpha);
						}
					}

					$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
					//die($bufferFilter);
				}

				// searchCategory
				// filter by type of startup: alumni
				if (!empty($filter['searchCategory'])) {
					$filterSearchCategory = $filter['searchCategory'];

					// $bufferFilter .= sprintf(" AND (%s)", $bufferSubFilter);
				}

				// persona
				if (!empty($filter['persona'])) {
					$filterPersonas = array_map('trim', explode(',', $filter['persona']));
					$bufferSubFilter = '';
					foreach ($filterPersonas as $keyword) {
						$bufferSubFilter .= sprintf("persona.slug='%s' OR ", $keyword);
						$filters[] = array('type' => 'persona', 'code' => $keyword, 'title' => $slugTitleArray['personas'][$keyword]);
					}
					$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
					$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				}

				// industry
				if (!empty($filter['industry'])) {
					$filterIndustries = array_map('trim', explode(',', $filter['industry']));
					$bufferSubFilter = '';
					foreach ($filterIndustries as $keyword) {
						$bufferSubFilter .= sprintf("industry.slug='%s' OR ", $keyword);
						$filters[] = array('type' => 'industry', 'code' => $keyword, 'title' => $slugTitleArray['industries'][$keyword]);
					}
					$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
					$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				}
			}

			// is it magic alumni?
			// todo: filter magic alumni by event only owned by magic
			if ($filter['magic'] == 1) {
				$sqlCount = sprintf("SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				JOIN event_organization as eo ON (eo.organization_id=o.id)

				WHERE %s AND eo.as_role_code='selectedParticipant' GROUP BY o.id ORDER BY o.title ASC) tmp", $bufferFilter);

				$sql = sprintf("SELECT o.* FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				JOIN event_organization as eo ON (eo.organization_id=o.id)

				WHERE %s AND eo.as_role_code='selectedParticipant' GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ", $bufferFilter, $offset, $limitPerPage);
			}
			// is it magic sea?
			elseif ($filter['sea'] == 1 || $filter['sebasic'] == 1) {
				if ($filter['sea'] == 1) {
					$ideaMembershipType = "mi1.value='idea'"; // 'idea';
					$extraJoin = '';
				} else {
					// se.a should appear in se basic list too
					$ideaMembershipType = "(mi1.value='default' OR mi1.value='idea')"; // 'default';
					$extraJoin = "INNER JOIN sea_form_basic as sfb ON o.id = sfb.organization_id AND sfb.status = 'approved'";
				}

				$sqlCount = sprintf("SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				LEFT JOIN event_organization as eo ON (eo.organization_id=o.id AND eo.as_role_code='selectedParticipant')

				INNER JOIN `meta_structure` as ms1 on ms1.ref_table='organization'
				INNER JOIN `meta_item` as mi1 on mi1.meta_structure_id=ms1.id

				INNER JOIN `meta_structure` as ms2 on ms2.ref_table='organization'
				INNER JOIN `meta_item` as mi2 on mi2.meta_structure_id=ms2.id

				%s

				WHERE %s
				AND (ms1.code='Organization-idea-membershipType' AND %s AND mi1.ref_id=o.id)
				AND (ms2.code='Organization-idea-isEnterprise' AND mi2.value='1' AND mi2.ref_id=o.id)

				GROUP BY o.id ORDER BY o.title ASC) tmp", $extraJoin, $bufferFilter, $ideaMembershipType);

				$sql = sprintf("SELECT o.* FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				LEFT JOIN event_organization as eo ON (eo.organization_id=o.id AND eo.as_role_code='selectedParticipant')

				INNER JOIN `meta_structure` as ms1 on ms1.ref_table='organization'
				INNER JOIN `meta_item` as mi1 on mi1.meta_structure_id=ms1.id

				INNER JOIN `meta_structure` as ms2 on ms2.ref_table='organization'
				INNER JOIN `meta_item` as mi2 on mi2.meta_structure_id=ms2.id

				%s

				WHERE %s
				AND (ms1.code='Organization-idea-membershipType' AND %s AND mi1.ref_id=o.id)
				AND (ms2.code='Organization-idea-isEnterprise' AND mi2.value='1' AND mi2.ref_id=o.id)

				GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ", $extraJoin, $bufferFilter, $ideaMembershipType, $offset, $limitPerPage);
			} elseif ($filter['ecosystem-builder'] == 1) {
				$sqlCount = sprintf("SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				JOIN event_organization as eo ON (eo.organization_id=o.id)

				WHERE %s AND eo.as_role_code='selectedParticipant' GROUP BY o.id ORDER BY o.title ASC) tmp", $bufferFilter);

				$sql = sprintf("SELECT o.* FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				JOIN event_organization as eo ON (eo.organization_id=o.id)

				WHERE %s AND eo.as_role_code='selectedParticipant' GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ", $bufferFilter, $offset, $limitPerPage);
			} else {
				$sqlCount = sprintf("SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				LEFT JOIN event_organization as eo ON (eo.organization_id=o.id AND eo.as_role_code='selectedParticipant')

				WHERE %s GROUP BY o.id ORDER BY o.title ASC) tmp", $bufferFilter);

				$sql = sprintf("SELECT o.* FROM organization as `o`
				LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
				LEFT JOIN persona as persona ON p2o.persona_id=persona.id

				LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
				LEFT JOIN industry as industry ON i2o.industry_id=industry.id

				LEFT JOIN event_organization as eo ON (eo.organization_id=o.id AND eo.as_role_code='selectedParticipant')

				WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ", $bufferFilter, $offset, $limitPerPage);
			}

			// echo $sql;exit;
			//die(123);
			$return['sql'] = str_replace(array("\t", "\n"), ' ', $sql);
			$return['filters'] = $filters;
			$return['items'] = Organization::model()->findAllBySql($sql);
			$return['countPageItems'] = count($return['items']);
			$return['limit'] = $limitPerPage;
			$return['totalItems'] = Yii::app()->db->createCommand($sqlCount)->queryScalar();
			$return['totalPages'] = ceil($return['totalItems'] / $limit);

			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getOrganizationAllActiveForAutoComplete($filter = '', $limit = 10)
	{
		// todo: implement cache
		$bufferFilter = 'o.is_active=1';
		$filters = array();

		$slugTitleArray = [
			'personas' => self::getOrganizationPersonas(true),
			'industries' => self::getOrganizationIndustries(true),
		];

		if (!empty($filter) && is_array($filter)) {
			// searchTitle
			// filter out unwanted characters for security purpose
			$filter['searchTitle'] = preg_replace('/[^A-Za-z0-9]/', '', $filter['searchTitle']);
			if (!empty($filter['searchTitle'])) {
				$filterSearchTitles = array_map('trim', explode(',', $filter['searchTitle']));
				$bufferSubFilter = '';
				foreach ($filterSearchTitles as $keyword) {
					$bufferSubFilter .= sprintf("o.title LIKE '%%%s%%' OR ", $keyword);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// searchAlpha
			// filter out unwanted characters for security
			if ($filter['searchAlpha'] !== '0-9') {
				$filter['searchAlpha'] = preg_replace('/[^A-Za-z0-9]/', '', $filter['searchAlpha']);
			}
			if (!empty($filter['searchAlpha'])) {
				$filterSearchAlpha = $filter['searchAlpha'];

				if (empty($filter['searchTitle'])) {
					$bufferSubFilter .= sprintf("o.title LIKE '%s%%'", $filterSearchAlpha);
				} else {
					$bufferSubFilter .= sprintf(" AND o.title LIKE '%s%%'", $filterSearchAlpha);
				}

				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				//die($bufferFilter);
			}

			// persona
			$filter['persona'] = preg_replace('/[^A-Za-z0-9\,]/', '', $filter['persona']);
			if (!empty($filter['persona'])) {
				$filterPersonas = array_map('trim', explode(',', $filter['persona']));
				$bufferSubFilter = '';
				foreach ($filterPersonas as $keyword) {
					$bufferSubFilter .= sprintf("persona.slug='%s' OR ", $keyword);
					$filters[] = array('type' => 'persona', 'code' => $keyword, 'title' => $slugTitleArray['personas'][$keyword]);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}

			// industry
			$filter['industry'] = preg_replace('/[^A-Za-z0-9\,]/', '', $filter['industry']);
			if (!empty($filter['industry'])) {
				$filterIndustries = array_map('trim', explode(',', $filter['industry']));
				$bufferSubFilter = '';
				foreach ($filterIndustries as $keyword) {
					$bufferSubFilter .= sprintf("industry.slug='%s' OR ", $keyword);
					$filters[] = array('type' => 'industry', 'code' => $keyword, 'title' => $slugTitleArray['industries'][$keyword]);
				}
				$bufferSubFilter = substr($bufferSubFilter, 0, -1 * strlen('OR '));
				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
			}
		}
		$filter['magic'] = preg_replace('/[^A-Za-z0-9]/', '', $filter['magic']);
		if ($filter['magic'] === 1) {
			$tempSql .= 'SELECT o.* FROM organization as `o`
                    LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
                    LEFT JOIN persona as persona ON p2o.persona_id=persona.id

                    LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
                    LEFT JOIN industry as industry ON i2o.industry_id=industry.id

                    JOIN event_organization as eo ON eo.organization_id=o.id

                    WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s';

			$sql = sprintf($tempSql, $bufferFilter, $limit);
		} else {
			$tempSql .= 'SELECT o.* FROM organization as `o`
                    LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
                    LEFT JOIN persona as persona ON p2o.persona_id=persona.id

                    LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
                    LEFT JOIN industry as industry ON i2o.industry_id=industry.id

                    WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s';

			$sql = sprintf($tempSql, $bufferFilter, $limit);
		}

		//echo $sql;
		//die(123);
		$return['sql'] = $sql;
		$return['filters'] = $filters;
		$return['items'] = Organization::model()->findAllBySql($sql);
		$return['countPageItems'] = count($return['items']);
		$return['limit'] = $limit;
		$return['totalItems'] = $limit;
		$return['totalPages'] = ceil($return['totalItems'] / $limit);

		return $return;
	}

	public static function getOrganizationPersonas($returnOneAssocArray = false)
	{
		return HubOrganization::getOrganizationPersonas($returnOneAssocArray);
	}

	public static function getOrganizationIndustries($returnOneAssocArray = false)
	{
		return HubOrganization::getOrganizationIndustries($returnOneAssocArray);
	}

	public static function getOrganization2Email($id)
	{
		return HubOrganization::getOrganization2Email($id);
	}

	public static function getOrganization2EmailUserID($organizationID, $userEmail)
	{
		return HubOrganization::getOrganization2EmailUserID($organizationID, $userEmail);
	}

	public static function getOrganization2Emails($organizationId, $pagi = '')
	{
		return HubOrganization::getOrganization2Emails($organizationId, $pagi);
	}

	public static function doOrganizationsMerge($source, $target)
	{
		return HubOrganization::doOrganizationsMerge($source, $target);
	}

	// pass in keyword of the organization title, email of the owner
	// return list of organizations where title matching, and is joinable by the email provided, limit to 10
	public static function getUserOrganizationsCanJoin($keyword, $email)
	{
		return HubOrganization::getUserOrganizationsCanJoin($keyword, $email);
	}

	/*
	 * do save the organization after merging for history
	 */
	public static function createOrganizationMergeHistory($source, $target)
	{
		return HubOrganization::createOrganizationMergeHistory($source, $target);
	}

	//
	// product
	public static function getProduct($id)
	{
		$product = Product::model()->findByPk($id);
		if ($product === null) {
			throw new CHttpException(404, 'The requested product does not exist.');
		}

		return $product;
	}

	public static function createProduct($title, $organization, $userEmail, $params)
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$product = new Product();
			$product->scenario = 'create';

			// check enterprise organization is active
			if (!$organization->is_active) {
				throw new Exception('Organization not found');
			}
			// check is enterprise organization belongs to userEmail
			if (!$organization->canAccessByUserEmail($userEmail)) {
				throw new Exception('Invalid access');
			}
			$product->title = $title;
			$product->organization_id = $organization->id;

			if (!empty($params['productCategoryId'])) {
				$product->product_category_id = $params['productCategoryId'];
			}

			$product->text_short_description = $params['shortDescription'];
			$product->typeof = $params['typeof'];
			$product->url_website = $params['urlWebsite'];
			$product->image_cover = 'uploads/product/cover.default.jpg';

			if ($product->save()) {
				$log = Yii::app()->esLog->log('created product', 'product', array('trigger' => 'HUB::createProduct', 'model' => 'Product', 'action' => 'create', 'id' => $product->id, 'organizationId' => $organization->id), $userEmail);

				$transaction->commit();
			} else {
				throw new Exception(Yii::app()->controller->modelErrors2String($product->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $product;
	}

	public static function updateProduct($product, $organizationCode, $userEmail, $params)
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$product->scenario = 'update';

			// check is product match with organizationCode
			if ($product->organization->code != $organizationCode) {
				throw new Exception('Invalid Access');
			}
			// check is organization is active
			if (!$product->organization->is_active) {
				throw new Exception('Organization not found');
			}
			// check product is active
			if (!$product->is_active) {
				throw new Exception('Product not found');
			}
			// check is product belongs organization that belongs to userEmail
			if (!$product->organization->canAccessByUserEmail($userEmail)) {
				throw new Exception('Invalid access');
			}
			if (!empty($params['title'])) {
				$product->title = $params['title'];
			}
			if (!empty($params['productCategoryId'])) {
				$product->product_category_id = $params['productCategoryId'];
			}
			if (!empty($params['shortDescription'])) {
				$product->text_short_description = $params['shortDescription'];
			}
			if (!empty($params['typeof'])) {
				$product->typeof = $params['legalFotypeofrmId'];
			}
			if (!empty($params['urlWebsite'])) {
				$product->url_website = $params['urlWebsite'];
			}

			if ($product->save()) {
				$log = Yii::app()->esLog->log('updated product', 'product', array('trigger' => 'HUB::updateProduct', 'model' => 'Product', 'action' => 'update', 'id' => $product->id, 'organizationId' => $product->organization->id), $userEmail);

				$transaction->commit();
			} else {
				throw new Exception(Yii::app()->controller->modelErrors2String($product->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $product;
	}

	//
	// individual
	public static function getIndividual($id)
	{
		return HubIndividual::getIndividual($id);
	}

	public static function getIndividualPersonas($returnOneAssocArray)
	{
		return HubIndividual::getIndividualPersonas($returnOneAssocArray);
	}

	public static function getIndividual2Email($id)
	{
		return HubIndividual::getIndividual2Email($id);
	}

	public static function getIndividual2EmailUserID($individualId, $userEmail)
	{
		return HubIndividual::getIndividual2EmailUserID($individualId, $userEmail);
	}

	public static function getIndividual2Emails($individualId, $pagi = '')
	{
		return HubIndividual::getIndividual2Emails($individualId, $pagi);
	}

	public static function doIndividualsMerge($source, $target)
	{
		return HubIndividual::doIndividualsMerge($source, $target);
	}

	/*
	 * do save the individual after merging for history
	 */
	public static function createIndividualMergeHistory($source, $target)
	{
		return HubIndividual::createIndividualMergeHistory($source, $target);
	}

	// charge
	public static function getChargeByCode($code)
	{
		return Charge::code2obj($code);
	}

	//
	// paypal
	public static function processPaypalPDT($txToken)
	{
		$pp_hostname = Yii::app()->params['paypalSslHost'];
		$auth_token = '766jg_O0elUD_O7TFlHESLBo6W2JrUGEFuKCNombo7y_pWOKT0lH0rxUvHG';

		$req = 'cmd=_notify-synch';

		$tx_token = $txToken;
		$req .= "&tx=$tx_token&at=$auth_token";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
		//if your server does not bundled with default verisign certificates.
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
		$res = curl_exec($ch);
		curl_close($ch);
		if (!$res) {
			//HTTP ERROR
		} else {
			// parse the data
			$lines = explode("\n", trim($res));
			$keyarray = array();
			if (strcmp($lines[0], 'SUCCESS') == 0) {
				for ($i = 1; $i < count($lines); ++$i) {
					$temp = explode('=', $lines[$i], 2);
					$keyarray[urldecode($temp[0])] = urldecode($temp[1]);
				}
			} elseif (strcmp($lines[0], 'FAIL') == 0) {
				// log for manual investigation
			}

			return $keyarray;
		}

		return false;
	}

	//
	// transaction

	//
	// transaction tx
	// insert or update existing transaction
	public static function insertOrUpdateTransaction($vendor, $txnId, $txntype, $jsonPayload, $params)
	{
		$msg = '';
		$status = 'fail';

		//echo $vendor;echo $txnId;
		$payload = json_decode($jsonPayload);

		switch ($vendor) {
			case 'paypal':

				/*
				[mc_gross] => 0.99
				[invoice] => test-147620951
				[protection_eligibility] => Eligible
				[payer_id] => SFPSNKHWLKZ6Y
				[tax] => 0.00
				[payment_date] => 22:47:54 Jun 04, 2017 PDT
				[payment_status] => Completed
				[charset] => windows-1252
				[first_name] => Yee Siang
				[mc_fee] => 0.99
				[custom] => {"refType":"charge","refId":"test-147620951"}
				[payer_status] => unverified
				[business] => exiang83-seller@gmail.com
				[quantity] => 1
				[payer_email] => exiang83-buyer2@gmail.com
				[txn_id] => 9NK975226Y869412D
				[payment_type] => instant
				[last_name] => Tan
				[receiver_email] => exiang83-seller@gmail.com
				[payment_fee] =>
				[shipping_discount] => 0.00
				[insurance_amount] => 0.00
				[receiver_id] => WQRSTT3WU77EQ
				[txn_type] => web_accept
				[item_name] => Test Payment
				[discount] => 0.00
				[mc_currency] => MYR
				[item_number] =>
				[residence_country] => MY
				[handling_amount] => 0.00
				[shipping_method] => Default
				[transaction_subject] =>
				[payment_gross] =>
				[shipping] => 0.00
				*/
				$tx = Transaction::getObjByTxn($vendor, $txnId);
				if (empty($tx)) {
					$tx = new Transaction();
				}

				$tx->vendor = 'paypal';
				$tx->txnid = $payload->txn_id;
				$tx->txntype = $payload->txn_type;
				$tx->currency_code = $payload->mc_currency;
				$tx->amount = $payload->mc_gross;

				$tx->ref_id = $payload->invoice;
				if (!empty($payload->custom)) {
					$custom = json_decode($payload->custom, true);
				}
				$tx->ref_type = $custom['refType'];

				$tx->status = $payload->payment_status;
				$tx->is_valid = ($tx->status == 'Completed') ? 1 : 0;
				$tx->jsonArray_payload = $payload;

				if ($tx->save()) {
					$status = 'success';
					$data = array('id' => $tx->id, 'isValid' => $tx->isValid(), 'amount' => $tx->amount);
				} else {
					$msg = Yii::app()->controller->modelErrors2String($tx->getErrors());
				}

				break;
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}

	// get transaction by ref_id
	public static function getTransactionsByRefId($refId, $pagi = null)
	{
		$pagi['auto'] = isset($pagi['auto']) ? $pagi['auto'] : false;
		$pagi['currentPage'] = isset($pagi['currentPage']) ? $pagi['currentPage'] : 0;
		$pagi['pageSize'] = isset($pagi['pageSize']) ? $pagi['pageSize'] : 10;

		$criteria = new CDbCriteria();
		$criteria->compare('ref_id', $refId);

		if ($pagi['auto'] == false) {
			$pagination = array('pageSize' => $pagi['pageSize'], 'currentPage' => $pagi['currentPage'], 'validateCurrentPage' => false);
		}

		$dataProvider = new CActiveDataProvider('Transaction', array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.date_modified DESC'),
			'pagination' => $pagination,
		));

		return array(
			'model' => $dataProvider->getData(),
			'dataProvider' => $dataProvider,
			'totalItemCount' => intval($dataProvider->totalItemCount),
			'pages' => $dataProvider->pagination,
		);
	}

	//
	// service
	public static function getAllActiveServices()
	{
		return Service::model()->findAllByAttributes(array('is_active' => 1));
	}

	public static function getServiceSlug($slug)
	{
		return Service::model()->findByAttributes(array('slug' => $slug));
	}

	public static function listServiceBookmarkable()
	{
		$return = Service::model()->isActive()->isBookmarkable()->findAll(array('order' => 'slug ASC'));

		return $return;
	}

	public static function setServiceBookmarkByUser($user, $csvServices)
	{
		if (empty($csvServices)) {
			throw new Exception(Yii::t('app', 'You must insert at least one service to bookmark'));
		}
		$csvServices = explode(',', $csvServices);

		if (!empty($csvServices)) {
			// clear all existing service of user
			Service2User::model()->deleteAll("user_id='{$user->id}'");

			foreach ($csvServices as $serviceSlug) {
				$serviceSlug = trim($serviceSlug);
				$service = self::getServiceSlug($serviceSlug);
				if ($service->canBookmarkByUser($user->id)) {
					$service2user = new Service2User();
					$service2user->user_id = $user->id;
					$service2user->service_id = $service->id;
					$service2user->save();
				}
			}
		}

		return self::listServiceBookmarkByUser($user);
	}

	public static function listServiceBookmarkByUser($user)
	{
		$return = Service2User::model()->with('service')->findAll(array('condition' => sprintf("user_id='%s'", $user->id), 'order' => 'service.slug ASC'));

		return $return;
	}

	//
	// master
	public static function getAllActiveLegalForms($countryCode = 'MY')
	{
		return HubMaster::getAllActiveLegalForms($countryCode);
	}

	public static function getAllActiveIndustries()
	{
		return HubMaster::getAllActiveIndustries();
	}

	public static function getAllActiveProductCategories()
	{
		return HubMaster::getAllActiveProductCategories();
	}

	public static function getAllActiveImpacts()
	{
		return HubMaster::getAllActiveImpacts();
	}

	public static function getAllActiveClusters()
	{
		return HubMaster::getAllActiveClusters();
	}

	public static function getAllActivePersonas()
	{
		return HubMaster::getAllActivePersonas();
	}

	public static function getAllActiveStartupStages()
	{
		return HubMaster::getAllActiveStartupStages();
	}

	public static function getAllActiveSdgs()
	{
		return HubMaster::getAllActiveSdgs();
	}

	//
	// notify

	// register and send notification right away
	// message can either be a string or a json payload
	// priority, default to 3, 1 is least important, 5 is most important
	public static function sendNotify($userType, $username, $message, $title = '', $content = '', $priority = 3, $options = null)
	{
		$hasSms = $hasEmail = $hasPush = 0;

		// construct notify object
		$notify = new Notify();

		switch ($userType) {
			case 'member':

				$member = Member::username2obj($username);
				if (empty($member)) {
					return false;
				}
				$receiverId = $member->user->id;

				$hasSms = (int) $member->canReceiveSms();
				$hasEmail = (int) $member->canReceiveEmail();
				//$hasPush = (int)$member->canReceivePush();

				$notify->receiverFullName = $member->user->profile->full_name;
				if ($hasSms) {
					$notify->receiverMobileNo = $member->getMobileNo();
				}
				if ($hasEmail) {
					$notify->receiverEmail = $member->getEmail();
				}
				/*if($hasPush)
				{
					$device = $member->getPrimaryDevice();
					$notify->receiverDeviceId = $device->id;
					$notify->receiverDeviceToken = $device->device_key;
					$notify->receiverDeviceType = $device->device_platform;
				}
				$channelId = self::getPubNubChannelId($userType, $member->user_id, $member);*/
				break;

			case 'admin':

				$admin = Admin::username2obj($username);
				if (empty($admin)) {
					return false;
				}
				$receiverId = $admin->user->id;

				$hasSms = (int) $admin->canReceiveSms();
				$hasEmail = (int) $admin->canReceiveEmail();
				//$hasPush = (int)$admin->canReceivePush();

				$notify->receiverFullName = $admin->user->profile->full_name;
				if ($hasSms) {
					$notify->receiverMobileNo = $admin->getMobileNo();
				}
				if ($hasEmail) {
					$notify->receiverEmail = $admin->getEmail();
				}
				/*if($hasPush)
				{
					$device = $admin->getPrimaryDevice();
					$notify->receiverDeviceId = $device->id;
					$notify->receiverDeviceToken = $device->device_key;
					$notify->receiverDeviceType = $device->device_platform;
				}
				$channelId = self::getPubNubChannelId($userType, $admin->user_id, $admin);*/
				break;

			case 'organization':

				$organization = Organization::code2Obj($username);
				if (empty($organization)) {
					return false;
				}
				$receiverId = $organization->id;

				$hasSms = (int) $organization->canReceiveSms();
				$hasEmail = (int) $organization->canReceiveEmail();
				//$hasPush = (int)$organization->canReceivePush();

				$notify->receiverFullName = $organization->getFullName();
				if ($hasSms) {
					$notify->receiverMobileNo = $organization->getMobileNo();
				}
				if ($hasEmail) {
					$notify->receiverEmail = $organization->getEmail();
				}

				/*if($hasPush)
				{
					$device = $organization->getPrimaryDevice();
					if(!empty($device))
					{
						$notify->receiverDeviceId = $device->id;
						$notify->receiverDeviceToken = $device->device_key;
						$notify->receiverDeviceType = $device->device_platform;
					}
				}
				$channelId = self::getPubNubChannelId($userType, $organization->id, $organization);*/
				break;

			default:

				//$this->outputFail(Yii::t('app', 'User type is required'), $meta);
				throw new Exception('User type is required');
		}

		$notify->receiver_id = $receiverId;
		$notify->receiver_type = $userType;
		$notify->sender_type = 'system';
		$notify->hasSms = $hasSms;
		$notify->hasEmail = $hasEmail;
		$notify->hasPush = $hasPush;
		$notify->content = $content;
		$notify->title = $title;
		$notify->priority = $priority;

		$notify->message = $message;
		$jsonPayload = json_decode($notify->message);
		// set timestamp so the web notify can works accordingly
		$jsonPayload->timestamp = self::now();
		if (!ysUtil::isJson($message)) {
			$jsonPayload->msg = $message;
		}
		// message should always in plain text
		$notify->message = $jsonPayload->msg;
		$notify->jsonArray_payload = $jsonPayload;

		// send sms
		if ($notify->hasSms) {
			$tmp = self::sendSms($notify->receiverMobileNo, $jsonPayload->msg);
			$notify->sentSms = (!empty($tmp) && $tmp->messages[0]->status == 0) ? 1 : 0;
		}
		// send email
		if ($notify->hasEmail) {
			$tmp = self::sendEmail($notify->receiverEmail, $notify->receiverFullName, $notify->title, $notify->content, $options);
			$notify->sentEmail = ($tmp === true) ? 1 : 0;
		}
		// send push notification (deprecated as push is send with pubnub together)
		/*if($notify->hasPush)
		{
			$tmp = self::sendPush($notify->receiverDeviceType, $notify->receiverDeviceToken, $notify->message);
			$notify->sentPush = ($tmp['result'] == 1) ? 1 : 0;
		}*/

		// send real time push to website using pubnub
		//if(!empty($channelId)) self::sendPubNub($channelId, json_encode($jsonPayload));

		$notify->validate();
		$notify->save();

		return $notify;
	}

	// not implemented
	public static function sendSms($receiverMobileNo, $msg)
	{
	}

	public static function sendEmail($email, $name, $title, $content, $options = '')
	{
		$receivers[] = array('email' => $email, 'name' => $name);

		if (!empty($options) && !empty($options['email']['receivers'])) {
			foreach ($options['email']['receivers'] as $receiver) {
				$receivers[] = array('email' => $receiver['email'], 'name' => $receiver['name'], 'method' => $receiver['method']);
			}
		}

		return ysUtil::sendMail($receivers, $title, $content);
	}

	//
	// event
	public static function getEvent($id)
	{
		return HubEvent::getEvent($id);
	}

	public static function getEventCode($code)
	{
		return HubEvent::getEventCode($code);
	}

	public static function getEventRegistrationByID($registrationCode)
	{
		return HubEvent::getEventRegistrationByID($registrationCode);
	}

	public static function syncEventToResource($dateStart, $dateEnd, $limit = 1000000)
	{
		return HubEvent::syncEventToResource($dateStart, $dateEnd, $limit);
	}

	public static function getAllEventRegistrationsByEmail($user, $timestampStart, $timestampEnd)
	{
		$sql = sprintf("SELECT er.* FROM event as e LEFT JOIN event_registration as er ON er.event_code=e.code WHERE e.is_active=1 AND e.is_cancelled=0 AND er.email='%s' AND e.date_started>=%s AND e.date_started <%s GROUP BY e.id ORDER BY e.date_started DESC", trim($user->username), $timestampStart, $timestampEnd);

		$eventRegistrations = EventRegistration::model()->findAllBySql($sql);

		return $eventRegistrations;
	}

	//
	// insight
	public function getAllActiveInsightItems()
	{
		return HubInsight::getAllActiveItems();
	}

	public function getInsightReports()
	{
		return HubInsight::getReports();
	}

	//
	// actFeed
	public function getUserActFeed($user, $pYear = '', $pServices = '*')
	{
		if (empty($pYear)) {
			$pYear = date('Y');
		}

		$registeredServices = $result = array();

		$tmps = self::getAllActiveServices();
		foreach ($tmps as $tmp) {
			$allServices[] = $tmp->slug;
			$registeredServices[$tmp->slug] = $tmp->title;
		}

		if ($pServices == '*' || $pServices == '') {
			$services = $allServices;
		} else {
			$tmps = explode(',', $pServices);
			foreach ($tmps as $tmp) {
				if (in_array(trim($tmp), $allServices)) {
					$services[] = trim($tmp);
				}
			}
		}

		// get approved active organizations
		$organizations = self::getActiveOrganizations($user->username, 'approve');

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getUserActFeed', sha1(json_encode(array('v4', $user->username, $pYear, $pServices, serialize($registeredServices)))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			// loop thru each available service
			foreach ($services as $service) {
				if (method_exists(Yii::app()->getModule($service), 'getUserActFeed')) {
					$feeds = Yii::app()->getModule($service)->getUserActFeed($user, $pYear);

					// get user feed of this service
					if (!empty($feeds)) {
						$result = array_merge($result, $feeds);
					}
				}

				// loop thru each organizations that user is in
				foreach ($organizations as $organization) {
					// get feeds of this organization in this service
					if (method_exists(Yii::app()->getModule($service), 'getOrganizationActFeed')) {
						$feeds = Yii::app()->getModule($service)->getOrganizationActFeed($organization, $pYear);

						// get user feed of this service
						if (!empty($feeds)) {
							$result = array_merge($result, $feeds);
						}
					}
				}
			}

			foreach ($result as &$r) {
				$r['serviceTitle'] = $registeredServices[$r['service']];
			}

			// loop thru all and sort by timestamp
			usort($result, 'self::cmpUserActFeed');

			Yii::app()->cache->set($cacheId, $result, 300);
			$return = $result;
		}

		return $return;
	}

	protected function cmpUserActFeed($a, $b)
	{
		if ($a['timestamp'] == $b['timestamp']) {
			return 0;
		}

		return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
	}

	// todo: cache
	public function getSystemActFeed($dateStart, $dateEnd, $forceRefresh = 0)
	{
		// ys: it will be iedal to do caching here at this level, however, caching here will cache the model and it caused error for fixSpatial() function when it is called by toApi() at WAPI level
		$limit = 30;
		$status = 'fail';
		$msg = 'Unknown error';

		// cache should not happens here or fixSpatial will trigger error
		Yii::import('application.modules.mentor.models.*');

		$timestampStart = strtotime($dateStart);
		$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

		// date range can not be more than 60 days
		if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
			$msg = 'Max date range cannot more than 60 days';
		} else {
			$data['events'] = null;
			$sql = sprintf('SELECT * FROM event WHERE is_active=1 AND is_cancelled!=1 AND date_started>=%s AND date_started<%s ORDER BY date_started DESC LIMIT 0, %s', $timestampStart, $timestampEnd, $limit);
			$startEvents = Event::model()->findAllBySql($sql);
			foreach ($startEvents as $e) {
				//print_r($e);
				$data['events'][] = $e;
			}

			$data['newOrganizations'] = null;
			$sql = sprintf('SELECT * FROM organization WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC LIMIT 0, %s', $timestampStart, $timestampEnd, $limit);
			$organizations = Organization::model()->findAllBySql($sql);
			if (!empty($organizations)) {
				foreach ($organizations as $o) {
					//print_r($o);
					$data['newOrganizations'][] = $o;
				}
			}

			$data['newOrganizationEmailRequests'] = null;
			$sql = sprintf('SELECT * FROM organization2email WHERE (date_added>=%s AND date_added<%s) OR (date_modified>=%s AND date_modified<%s) ORDER BY date_modified DESC LIMIT 0, %s', $timestampStart, $timestampEnd, $timestampStart, $timestampEnd, $limit);
			$emails = Organization2Email::model()->findAllBySql($sql);
			if (!empty($emails)) {
				foreach ($emails as $e) {
					$data['newOrganizationEmailRequests'][] = $e;
				}
			}

			$data['modifiedResources'] = null;
			$sql = sprintf('SELECT * FROM resource WHERE is_active=1 AND date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC LIMIT 0, %s', $timestampStart, $timestampEnd, $limit);
			$resources = Resource::model()->findAllBySql($sql);
			foreach ($resources as $r) {
				$data['modifiedResources'][] = $r;
			}

			$sql = sprintf('SELECT * FROM user WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC LIMIT 0, %s', $timestampStart, $timestampEnd, $limit);
			$users = User::model()->findAllBySql($sql);
			if (!empty($users)) {
				foreach ($users as $u) {
					$data['newUsers'][] = $u;
				}
			}

			$data['mentorBookings'] = null;
			$mentorPrograms = HubMentor::getActivePrograms();

			foreach ($mentorPrograms as $mp) {
				$bookings = HubFuturelab::getProgramBookings($mp->vendor_ref_code);
				usort($bookings, 'HubFuturelab::cmpBooking');
				$bookings = array_reverse($bookings);

				$tmps = null;
				foreach ($bookings as $b) {
					$timestampBooking = strtotime($b->booking_time);
					if ($timestampBooking >= $timestampStart && $timestampBooking < $timestampEnd) {
						if ($b->status == 'upcoming' || $b->status == 'history' || $b->status == 'archived') {
							$booking = new Booking();
							$booking->loadFrom($b);
							$tmps[] = $booking;
						}
					}
				}

				if (!empty($tmps)) {
					$data['mentorBookings'][] = array(
						'programName' => $mp->title,
						'upcomingBookings' => $tmps,
					);
				}
			}

			$status = 'success';
			$msg = '';
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}

	//
	// currency
	// get list of historical exchange rate of a date range, with USD as base
	public function getCurrencyExchangeRatesHistoricalData($dateStart, $dateEnd)
	{
		$timestampDateEnd = strtotime($dateEnd);
		$timestampDateStart = strtotime($dateStart);
		$result = $dateList = array();

		for ($i = $timestampDateStart; $i <= $timestampDateEnd; $i += 86400) {
			$dateList[] = date('Y-m-d', $i);
		}

		if (count($dateList) <= 31) {
			foreach ($dateList as $date) {
				$result[$date] = self::getCurrencyExchangeRatesData($date);
			}
		}

		return $result;
	}

	// from api
	// the base currently only work with USD as it is a free account
	public function getCurrencyExchangeRatesData($date, $base = 'USD')
	{
		$url = sprintf('https://openexchangerates.org/api/historical/%s.json?app_id=%s', $date, Yii::app()->params['openExchangeRatesAppId']);

		$client = new \GuzzleHttp\Client();

		$response = $client->request(
			'GET',
			$url,
			[
				'headers' => [
					'Accept' => 'application/json',
					'Content-Type' => 'application/json',
				],
				'form_params' => [
					'base' => $base,
				],
			]
		);
		$body = (string) $response->getBody();
		$json = json_decode($body, true);

		return $json['rates'];
	}

	// date in YYYY-mm-dd format
	public function recordCurrencyExchangeRates($date)
	{
		$baseCurrency = 'USD';
		$timestampDate = strtotime($date . ' GMT');

		$year = date('Y', $timestampDate);
		$month = date('m', $timestampDate);
		$day = date('d', $timestampDate);

		// get records of all currency
		$records = self::getCurrencyExchangeRatesData($date, $baseCurrency);

		foreach ($records as $toCurrency => $rate) {
			$cxr = CurrencyExchangeRate::getObjByKeys($baseCurrency, $toCurrency, $year, $month, $day);
			if (empty($cxr)) {
				$cxr = new CurrencyExchangeRate();
			}

			$cxr->from_currency_code = $baseCurrency;
			$cxr->to_currency_code = $toCurrency;
			$cxr->rate = $rate;
			$cxr->year = $year;
			$cxr->month = $month;
			$cxr->day = $day;
			$cxr->date_record = $timestampDate;

			$cxr->save();
		}

		return $records;
	}

	// from database, if not found, will get from live api and stored in databse
	public function getCurrencyExchangeRate($fromCurrency, $toCurrency, $date)
	{
		$timestampDate = strtotime($date . ' GMT');
		// enforce: if date is tomorrow and onwards, use today date. i cant forsee the future ya ;)
		$timestampTomorrow = strtotime('Tomorrow GMT');
		if ($timestampDate >= $timestampTomorrow) {
			$timestampDate = time();
		}

		$year = date('Y', $timestampDate);
		$month = date('m', $timestampDate);
		$day = date('d', $timestampDate);

		// get the from to usd first
		$cxrFrom2Usd = CurrencyExchangeRate::getObjByKeys('USD', $fromCurrency, $year, $month, $day);
		// if not found in db, call the live api and update to db
		if (empty($cxrFrom2Usd)) {
			// only need to do this once
			$rates = self::recordCurrencyExchangeRates($date);
			$rateFrom2Usd = $rates[$fromCurrency];
		} else {
			$rateFrom2Usd = $cxrFrom2Usd->rate;
		}

		$cxrTo2Usd = CurrencyExchangeRate::getObjByKeys('USD', $toCurrency, $year, $month, $day);
		// if not found in db, call the live api and update to db
		if (empty($cxrTo2Usd)) {
			$rateTo2Usd = $rates[$toCurrency];
		} else {
			$rateTo2Usd = $cxrTo2Usd->rate;
		}

		//echo $rateTo2Usd;exit;
		$rate = 1 / $rateFrom2Usd * $rateTo2Usd;

		return $rate;
	}

	public function convertCurrency($amount, $fromCurrency, $toCurrency, $date)
	{
		$status = 'fail';
		$msg = 'Unknown error';
		$timestampDate = strtotime($date . ' GMT');
		// enforce: if date is tomorrow and onwards, use today date. i cant forsee the future ya ;)
		$timestampTomorrow = strtotime('Tomorrow GMT');
		if ($timestampDate >= $timestampTomorrow) {
			$timestampDate = time();
		}

		$year = date('Y', $timestampDate);
		$month = date('m', $timestampDate);
		$day = date('d', $timestampDate);

		try {
			// get the rate in USD (a limitation due to free account)
			$rate = self::getCurrencyExchangeRate($fromCurrency, $toCurrency, $date);

			$data = array(
				'date' => sprintf('%s-%s-%s', $year, $month, $day),
				'rate' => $rate,
				'amountOriginal' => floatval($amount),
				'amountConverted' => $amount * $rate,
			);
			$status = 'success';
			$msg = '';
		} catch (Exception $e) {
			$status = 'fail';
			$msg = $e->getMessage();
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}

	//
	// milestone
	public function sumMilestoneRevenueRealized()
	{
		$sql = "SELECT SUM(JSON_UNQUOTE(JSON_EXTRACT(json_value, CONCAT(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_SEARCH(json_value, 'all', 'true')), '.', 4), '.value')))) AS sum
		FROM milestone WHERE SUBSTRING_INDEX(JSON_UNQUOTE(JSON_SEARCH(json_value, 'all', 'true')), '.', -1) = 'realized' AND preset_code='revenue'";

		return Yii::app()->db->createCommand($sql)->queryScalar();
	}

	//
	// organizationFunding
	public function sumFunding()
	{
		$sql = 'SELECT SUM(amount) FROM `organization_funding` as of LEFT JOIN organization as o ON of.organization_id=o.id AND o.is_active=1';

		return Yii::app()->db->createCommand($sql)->queryScalar();
	}

	public function Encrypt($string)
	{
		try {
			$salt = Yii::app()->params['encryptionSalt'];

			return sha1($string . $salt);
		} catch (Exception $e) {
			throw $e;
		}
	}

	//This method is very destructive
	//IT will destory all user information we keep in the db.
	public function RemoveAccountCompletely($email)
	{
		//Yee Siang Request:
		//If the requested email is in Admin table we don't honor the request
		if (Admin::model()->findByAttributes(array('username' => $email))) {
			return 'Account is Admin and not removable';
		}

		$transaction = Yii::app()->db->beginTransaction();

		try {
			self::RemoveAccountEventRegistration($email);
			self::RemoveAccountEnvoyVisitor($email);
			self::RemoveAccountMember($email);
			self::RemoveAccountProfile($email);
			self::RemoveAccountUser($email);
			self::RemoveAccountOrganization2User($email);
			//self::RemoveAccountMentorSession($email);
			self::RemoveAccountMentorFutureLab2Email($email);
			$transaction->commit();

			return true;
		} catch (Exception $e) {
			echo $e;
			$transaction->rollback();

			return false;
		}
	}

	protected function RemoveAccountEventRegistration($email)
	{
		try {
			$records = EventRegistration::model()->findAllByAttributes(array('email' => $email));

			foreach ($records as $record) {
				$record->first_name = '';
				$record->last_name = '';
				$record->full_name = '';
				$record->json_original = '';
				$record->email = '';
				// We encrypt the existing Hash so that if user registered again
				// this record does not relate to the user.
				$record->email_hash = self::Encrypt($record->email_hash);

				if (!$record->save()) {
					throw new Exception('Error while saving Event registration');
				}
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from Event_Registration table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountEnvoyVisitor($email)
	{
		try {
			Yii::app()->db
				->createCommand("UPDATE envoy_visitor SET your_full_name='', your_company='', reason_for_visit='', your_phone_number='', your_email_address='', email_hash=sha1(email_hash), nda_pdf_url='' WHERE your_email_address=:email")
				->bindValues(array(':email' => $email))
				->execute();
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from Envoy_Visitor table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountMember($email)
	{
		try {
			$member = Member::username2obj($email);
			if (is_null($member)) {
				return;
			}
			if ($member->delete() == false) {
				throw new Exception('Failed to delete member');
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from Member table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountProfile($email)
	{
		try {
			$user = User::username2obj($email);

			if (is_null($user)) {
				return;
			}

			$profile = $user->profile;

			if (is_null($profile)) {
				return;
			}

			if ($profile->delete() == false) {
				throw new Exception("Failed to delete user's profile");
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from Profile table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountUser($email)
	{
		try {
			$user = User::username2obj($email);

			if (is_null($user)) {
				return;
			}

			//First delete connect user
			if (!$user->destroyRemoteConnectUser()) {
				throw new Exception('Failed to delete Connect user!');
			}
			if ($user->delete() == false) {
				throw new Exception('Failed to delete user account!');
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from User table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountOrganization2User($email)
	{
		try {
			$records = Organization2Email::model()->findAllByAttributes(array('user_email' => $email));

			foreach ($records as $record) {
				if ($record->delete() == false) {
					throw new Exception('Failed to remove organizer2email relation');
				}
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from Organization2Email table: ' . $e->getMessage());
		}
	}

	protected function RemoveAccountMentorSession($email)
	{
		try {
		} catch (Exception $e) {
			throw $e;
		}
	}

	protected function RemoveAccountMentorFutureLab2Email($email)
	{
		try {
			$records = MentorFuturelab2Email::model()->findAllByAttributes(array('user_email' => $email));

			foreach ($records as $record) {
				if ($record->delete() == false) {
					throw new Exception('Failed to remove MentorFutureLab2Email relation');
				}
			}
		} catch (Exception $e) {
			throw new Exception('Failed to remove account from MentorFutureLab2Email table: ' . $e->getMessage());
		}
	}

	/**
	 * to check whether role is allowed to access the route/action
	 *
	 * @param string $role
	 * @param object $controller
	 * @param string $action this param could be use for custom part to be accessed by the role
	 *
	 * @return boolean
	 **/
	public function roleCheckerAction($role, $controller, $action = '')
	{
		$roles = explode(',', $role);

		/*
		 * if user session is System Admin and role supplied
		 */
		if (in_array('superAdmin', $roles)) {
			// this checkAccess is defined in _accessView & _accessForm to check the route is been set to that role. so if it has been set then do not return true
			if (!isset($controller->checkAccess)) {
				return true;
			}
		}

		if (is_numeric($role)) {
			$column = 'roles.id';
		} else {
			$column = 'roles.code';
		}

		$criteria = new CDbCriteria;
		$criteria->with = ['roles'];

		$condition = 't.module=:module AND t.controller=:controller AND t.action=:action';
		$params = array(
			':module' => !empty($controller->module->id) ? $controller->module->id : '',
			':controller' => $controller->id,
			':action' => !empty($action) ? $action : $controller->action->id,
		);
		if (isset($filter) && isset($value)) {
			$condition .= " AND $filter";
			$params[':role'] = $value;
		}
		$criteria->condition = $condition;
		$criteria->params = $params;

		$criteria->addInCondition($column, $roles);
		//var_dump($column, $roles);

		// $count = Access::model()->with('roles')->count($condition, $params);
		$count = Access::model()->isActive()->count($criteria);

		return ($count > 0) ? true : false;
	}
}
