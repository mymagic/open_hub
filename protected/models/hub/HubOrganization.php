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

class HubOrganization
{
	public static function getOrCreateOrganization($title, $params = array())
	{
		try {
			$organization = self::getOrganizationByTitle($title);
		} catch (Exception $e) {
			$organization = null;
		}

		if ($organization === null) {
			$organization = self::createOrganization($title, $params);
		}

		return $organization;
	}

	public static function createOrganization($title, $params = array())
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$organization = new Organization();
			$organization->scenario = 'createOrganization';

			$params['organization']['title'] = $title;
			$organization->attributes = $params['organization'];

			if (!empty(UploadedFile::getInstance($organization, 'imageFile_logo'))) {
				$organization->imageFile_logo = UploadedFile::getInstance($organization, 'imageFile_logo');
			} else {
				$organization->image_logo = 'uploads/organization/logo.default.jpg';
			}

			if (!empty($organization->full_address)) {
				$organization->resetAddressParts();
			}

			if ($organization->save()) {
				UploadManager::storeImage($organization, 'logo', $organization->tableName());

				// add organization2email
				if (!empty($params['userEmail'])) {
					$o2e = new Organization2Email();
					$o2e->organization_id = $organization->id;
					$o2e->user_email = $params['userEmail'];
					$o2e->status = 'approve';
					$o2e->save();
				}

				$log = Yii::app()->esLog->log(sprintf("created '%s'", $organization->title), 'organization', array('trigger' => 'HUB::createOrganization', 'model' => 'Organization', 'action' => 'create', 'id' => $organization->id, 'organizationId' => $organization->id), '', array('userEmail' => $params['userEmail']));

				$transaction->commit();
			} else {
				throw new Exception(Yii::app()->controller->modelErrors2String($organization->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $organization;
	}

	public static function getOrganization($id)
	{
		$model = Organization::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested organization item does not exist.');
		}

		return $model;
	}

	public static function getOrganizationByCode($code)
	{
		$model = Organization::model()->code2obj($code);
		if ($model === null) {
			throw new CHttpException(404, 'The requested organization does not exist.');
		}

		return $model;
	}

	public static function getOrganizationByTitle($title)
	{
		$model = Organization::model()->title2obj($title);
		if ($model === null) {
			throw new CHttpException(404, 'The requested organization does not exist.');
		}

		return $model;
	}

	public static function getOrganizationBySlug($slug)
	{
		$model = Organization::model()->slug2obj($slug);
		if ($model === null) {
			throw new CHttpException(404, 'The requested organization does not exist.');
		}

		return $model;
	}

	public static function getUserOrganizations($email)
	{
		return self::getOrganizations($email, 'approve');
	}

	public static function getUserActiveOrganizations($email)
	{
		return self::getActiveOrganizations($email, 'approve');
	}

	public static function getOrganizations($email, $status = 'approve')
	{
		if ($status == '*') {
			return Organization::model()->with('organization2Emails')->findAll('user_email=:userEmail', array(':userEmail' => $email));
		} else {
			return Organization::model()->with('organization2Emails')->findAll('user_email=:userEmail AND status=:status', array(':userEmail' => $email, ':status' => $status));
		}
	}

	public static function getActiveOrganizations($email, $status = 'approve')
	{
		if ($status == '*') {
			return Organization::model()->isActive()->with('organization2Emails')->findAll('user_email=:userEmail', array(':userEmail' => $email));
		} else {
			return Organization::model()->isActive()->with('organization2Emails')->findAll('user_email=:userEmail AND status=:status', array(':userEmail' => $email, ':status' => $status));
		}
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

		if (!empty($filter) && is_array($filter)) {
			// searchTitle
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

				if (empty($filter['searchTitle'])) {
					$bufferSubFilter .= sprintf("o.title LIKE '%s%%'", $filterSearchAlpha);
				} else {
					$bufferSubFilter .= sprintf(" AND o.title LIKE '%s%%'", $filterSearchAlpha);
				}

				$bufferFilter .= sprintf(' AND (%s)', $bufferSubFilter);
				//die($bufferFilter);
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

		if ($filter['magic'] == 1) {
			$sqlCount = sprintf('SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o` 
			LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id 
			LEFT JOIN persona as persona ON p2o.persona_id=persona.id
			
			LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id 
			LEFT JOIN industry as industry ON i2o.industry_id=industry.id

			JOIN event_organization as eo ON eo.organization_id=o.id
		
			WHERE %s GROUP BY o.id ORDER BY o.title ASC) tmp', $bufferFilter);

			$sql = sprintf('SELECT o.* FROM organization as `o` 
			LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id 
			LEFT JOIN persona as persona ON p2o.persona_id=persona.id
			
			LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id 
			LEFT JOIN industry as industry ON i2o.industry_id=industry.id

			JOIN event_organization as eo ON eo.organization_id=o.id
		
			WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ', $bufferFilter, $offset, $limitPerPage);
		} else {
			$sqlCount = sprintf('SELECT COUNT(*) FROM (SELECT o.id FROM organization as `o` 
			LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id 
			LEFT JOIN persona as persona ON p2o.persona_id=persona.id
			
			LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id 
			LEFT JOIN industry as industry ON i2o.industry_id=industry.id

			WHERE %s GROUP BY o.id ORDER BY o.title ASC) tmp', $bufferFilter);

			$sql = sprintf('SELECT o.* FROM organization as `o` 
			LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id 
			LEFT JOIN persona as persona ON p2o.persona_id=persona.id
			
			LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id 
			LEFT JOIN industry as industry ON i2o.industry_id=industry.id
		
			WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ', $bufferFilter, $offset, $limitPerPage);
		}

		//echo $sql;
		// die($sql);
		$return['sql'] = $sql;
		$return['filters'] = $filters;
		$return['items'] = Organization::model()->findAllBySql($sql);
		$return['countPageItems'] = count($return['items']);
		$return['limit'] = $limitPerPage;
		$return['totalItems'] = Yii::app()->db->createCommand($sqlCount)->queryScalar();
		$return['totalPages'] = ceil($return['totalItems'] / $limit);

		return $return;
	}

	public static function getOrganizationPersonas($returnOneAssocArray = false)
	{
		$sql = 'SELECT p.* FROM `persona` as p, organization as o, persona2organization as p2o WHERE p2o.organization_id=o.id AND p2o.persona_id=p.id AND o.is_active=1 AND p.is_active=1 GROUP BY p.id';
		$assocArray = array();
		$return = array();
		$tmps = Persona::model()->findAllBySql($sql);
		foreach ($tmps as $tmp) {
			$assocArray[$tmp->slug] = $tmp->title;
			$return[] = array('slug' => $tmp->slug, 'title' => $tmp->title, 'textShortDescription' => '');
		}

		return $returnOneAssocArray ? $assocArray : $return;
	}

	public static function getOrganizationIndustries($returnOneAssocArray = false)
	{
		$sql = 'SELECT i.* FROM `industry` as i, organization as o, industry2organization as i2o WHERE i2o.organization_id=o.id AND i2o.industry_id=i.id AND o.is_active=1 AND i.is_active=1 GROUP BY i.id ORDER BY i.title ASC';
		$assocArray = array();
		$return = array();

		$tmps = Industry::model()->findAllBySql($sql);

		foreach ($tmps as $tmp) {
			if (!strstr($tmp->slug, '.')) {
				$childs = array();
				foreach ($tmps as $tmp2) {
					if (substr($tmp2->slug, 0, strlen($tmp->slug . '.')) == $tmp->slug . '.') {
						$assocArray[$tmp2->slug] = $tmp2->title;
						$childs[] = array('slug' => $tmp2->slug, 'title' => $tmp2->title, 'textShortDescription' => '');
					}
				}
				$assocArray[$tmp->slug] = $tmp->title;
				$return[] = array('slug' => $tmp->slug, 'title' => $tmp->title, 'textShortDescription' => '', 'childs' => $childs);
			}
		}

		return $returnOneAssocArray ? $assocArray : $return;
	}

	public static function getOrganization2Email($id)
	{
		$model = Organization2Email::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model;
	}

	public static function getOrganization2EmailUserID($organizationID, $userEmail)
	{
		$model = Organization2Email::model()->findByAttributes(array('organization_id' => $organizationID, 'user_email' => $userEmail));
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model->id;
	}

	public static function getOrganization2Emails($organizationId, $pagi = '')
	{
		$pagi['auto'] = isset($pagi['auto']) ? $pagi['auto'] : false;
		$pagi['currentPage'] = isset($pagi['currentPage']) ? $pagi['currentPage'] : 0;
		$pagi['pageSize'] = isset($pagi['pageSize']) ? $pagi['pageSize'] : 10;

		$criteria = new CDbCriteria();
		$criteria->compare('organization_id', $organizationId);

		if ($pagi['auto'] == false) {
			$pagination = array('pageSize' => $pagi['pageSize'], 'currentPage' => $pagi['currentPage'], 'validateCurrentPage' => false);
		}

		$dataProvider = new CActiveDataProvider('Organization2Email', array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.date_added DESC'),
			'pagination' => $pagination,
		));

		return array(
			'model' => $dataProvider->getData(),
			'dataProvider' => $dataProvider,
			'totalItemCount' => intval($dataProvider->totalItemCount),
			'pages' => $dataProvider->pagination,
		);
	}

	// pass in keyword of the organization title, email of the owner
	// return list of organizations where title matching, and is joinable by the email provided, limit to 10
	public static function getUserOrganizationsCanJoin($keyword, $email)
	{
		if (strlen($keyword) < 2) {
			return null;
		}

		$sql = sprintf("SELECT o.* FROM organization as o LEFT JOIN organization2email as oe ON oe.organization_id=o.id WHERE o.is_active=1 AND o.title LIKE '%s%%' AND oe.user_email!='%s' GROUP BY o.id ORDER BY title ASC LIMIT 0, 10", $keyword, $email);

		$return = Organization::model()->findAllBySql($sql);

		return $return;
	}

	// merge from source into target organization, then deactivate the source
	public static function doOrganizationsMerge($source, $target)
	{
		if (empty($source) || empty($target)) {
			throw new Exception('Invalid Organizations');
		}
		$transaction = Yii::app()->db->beginTransaction();
		try {
			// process attributes, if source is not empty but this is, replace
			if (empty($target->text_oneliner)) {
				$target->text_oneliner = $source->text_oneliner;
			}
			if (empty($target->text_short_description)) {
				$target->text_short_description = $source->text_short_description;
			}
			if (empty($target->html_content)) {
				$target->html_content = $source->html_content;
			}
			if (empty($target->company_number)) {
				$target->company_number = $source->company_number;
			}
			if (empty($target->legalform_id)) {
				$target->legalform_id = $source->legalform_id;
			}
			if (empty($target->image_logo)) {
				$target->image_logo = $source->image_logo;
			}
			if (empty($target->url_website)) {
				$target->url_website = $source->url_website;
			}
			if (empty($target->timezone)) {
				$target->timezone = $source->timezone;
			}
			if (empty($target->legal_name)) {
				$target->legal_name = $source->legal_name;
			}
			if (empty($target->full_address)) {
				$target->full_address = $source->full_address;
			}
			if (empty($target->address_line1)) {
				$target->address_line1 = $source->address_line1;
			}
			if (empty($target->address_line2)) {
				$target->address_line2 = $source->address_line2;
			}
			if (empty($target->address_zip)) {
				$target->address_zip = $source->address_zip;
			}
			if (empty($target->address_city)) {
				$target->address_city = $source->address_city;
			}
			if (empty($target->address_state)) {
				$target->address_state = $source->address_state;
			}
			if (empty($target->address_country_code)) {
				$target->address_country_code = $source->address_country_code;
			}
			if (empty($target->latlong_address)) {
				$target->latlong_address = $source->latlong_address;
			}

			// process dynamic data
			foreach ($source->_dynamicData as $dt => $dd) {
				if (empty($target->_dynamicData[$dt])) {
					$target->_dynamicData[$dt] = $dd;
				}
			}
			$target->save();

			// process charges
			if (!empty($source->charges)) {
				foreach ($source->charges as $charge) {
					$charge->charge_to_code = $target->code;
					$charge->save();
				}
			}

			// process organization2Emails
			// will not merge to target if same email address already exists
			if (!empty($source->organization2Emails)) {
				foreach ($source->organization2Emails as $organization2Email) {
					// if no duplicate
					if (!$target->hasUserEmail($organization2Email->user_email)) {
						$organization2Email->organization_id = $target->id;
						$organization2Email->save();
					}
				}
			}

			// process eventOrganizations
			if (!empty($source->eventOrganizations)) {
				foreach ($source->eventOrganizations as $eventOrganization) {
					// if no duplicate
					if (!$target->hasEventOrganization($eventOrganization->event->code, $eventOrganization->as_role_code)) {
						$eventOrganization->organization_id = $target->id;
						$eventOrganization->organization_name = $target->title;
						$eventOrganization->save();
					}
				}
			}

			// process individualOrganizations
			if (!empty($source->individualOrganizations)) {
				foreach ($source->individualOrganizations as $individualOrganization) {
					// if no duplicate
					if (!$target->hasIndividualOrganization($individualOrganization->individual->id, $individualOrganization->as_role_code)) {
						$individualOrganization->organization_code = $target->code;
						$individualOrganization->save();
					}
				}
			}

			// process products
			if (!empty($source->products)) {
				foreach ($source->products as $product) {
					$product->organization_id = $target->id;
					$product->save();
				}
			}

			// process sent notifies
			if (!empty($source->sentNotifies)) {
				foreach ($source->sentNotifies as $notify) {
					$notify->sender_id = $target->id;
					$notify->save();
				}
			}

			// process received notifies
			if (!empty($source->receivedNotifies)) {
				foreach ($source->receivedNotifies as $notify) {
					$notify->receiver_id = $target->id;
					$notify->save();
				}
			}

			// process organizationFundings
			$sql = sprintf('UPDATE organization_funding SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process organizationRevenues
			$sql = sprintf('UPDATE organization_revenue SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process organizationStatus
			$sql = sprintf('UPDATE organization_status SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process milestone
			$sql = sprintf('UPDATE milestone SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process impact2Organization
			$sql = sprintf('UPDATE IGNORE impact2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM impact2organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process sdg2Organization
			$sql = sprintf('UPDATE IGNORE sdg2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM sdg2organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process industry2Organization
			$sql = sprintf('UPDATE IGNORE industry2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM industry2organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process persona2Organization
			$sql = sprintf('UPDATE IGNORE persona2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM persona2organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process tag2organization
			$sql = sprintf('UPDATE IGNORE tag2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM tag2organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process event_organization
			/*$sql = sprintf('UPDATE IGNORE event_organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM event_organization WHERE organization_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute(); */

			// process survey_record
			$sql = sprintf('UPDATE survey_record SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// todo: f7 form, organization can be use in json so is hard to process

			// modularize:
			$modules = YeeModule::getParsableModules();
			foreach ($modules as $moduleKey => $moduleParams) {
				if (method_exists(Yii::app()->getModule($moduleKey), 'doOrganizationsMerge')) {
					list($source, $target) = Yii::app()->getModule($moduleKey)->doOrganizationsMerge($source, $target);
				}
			}

			// deactivate source
			$source->is_active = 0;
			$source->save();

			$log = Yii::app()->esLog->log(sprintf("merged and deactivated '%s' into '%s'", $source->title, $target->title), 'organization', array('trigger' => 'HUB::doOrganizationsMerge', 'model' => 'Organization', 'action' => '', 'id' => $source->id, 'organizationId' => $source->id));

			$log2 = Yii::app()->esLog->log(sprintf("merged into '%s' from '%s'", $target->title, $source->title), 'organization', array('trigger' => 'HUB::doOrganizationsMerge', 'model' => 'Organization', 'action' => '', 'id' => $target->id, 'organizationId' => $target->id));

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $target;
	}

	public static function createOrganizationMergeHistory($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$model = new OrganizationMergeHistory;
			$model->src_organization_id = $source->id;
			$model->dest_organization_id = $target->id;
			$model->dest_organization_title = $target->title;

			if ($model->save()) {
				$transaction->commit();
			} else {
				throw new Exception(Yii::app()->controller->modelErrors2String($model->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $model;
	}

	public function getSystemActFeed($dateStart, $dateEnd, $page=1, $forceRefresh = 0)
	{
		$limit = 30;
		$status = 'fail';
		$msg = 'Unknown error';

		$timestampStart = strtotime($dateStart);
		$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

		// date range can not be more than 60 days
		if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
			$msg = 'Max date range cannot more than 60 days';
		} else {
			$data = null;
			$sql = sprintf('SELECT * FROM organization WHERE is_active=1 AND date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC LIMIT %s, %s', $timestampStart, $timestampEnd, ($page-1)*$limit, $limit);
			$data = Organization::model()->findAllBySql($sql);

			$status = 'success';
			$msg = '';
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}
}
