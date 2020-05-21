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

class HubIndividual
{
	public static function getIndividual($id)
	{
		$model = Individual::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested individual item does not exist.');
		}

		return $model;
	}

	public static function getIndividualPersonas($returnOneAssocArray = false)
	{
		$sql = 'SELECT p.* FROM `persona` as p, individual as i, persona2individual as p2i WHERE p2i.individual_id=i.id AND p2i.persona_id=p.id AND i.is_active=1 AND p.is_active=1 GROUP BY p.id';
		$assocArray = array();
		$return = array();
		$tmps = Persona::model()->findAllBySql($sql);
		foreach ($tmps as $tmp) {
			$assocArray[$tmp->slug] = $tmp->title;
			$return[] = array('slug' => $tmp->slug, 'title' => $tmp->title, 'textShortDescription' => '');
		}

		return $returnOneAssocArray ? $assocArray : $return;
	}

	public static function getIndividual2Email($id)
	{
		$model = Individual2Email::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model;
	}

	public static function getIndividual2EmailUserID($individualId, $userEmail)
	{
		$model = Individual2Email::model()->findByAttributes(array('individual_id' => $individualId, 'user_email' => $userEmail));
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model->id;
	}

	public static function getIndividual2Emails($individualId, $pagi = '')
	{
		$pagi['auto'] = isset($pagi['auto']) ? $pagi['auto'] : false;
		$pagi['currentPage'] = isset($pagi['currentPage']) ? $pagi['currentPage'] : 0;
		$pagi['pageSize'] = isset($pagi['pageSize']) ? $pagi['pageSize'] : 10;

		$criteria = new CDbCriteria();
		$criteria->compare('individual_id', $individualId);

		if ($pagi['auto'] == false) {
			$pagination = array('pageSize' => $pagi['pageSize'], 'currentPage' => $pagi['currentPage'], 'validateCurrentPage' => false);
		}

		$dataProvider = new CActiveDataProvider('Individual2Email', array(
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

	// missing

	// merge from source into target individual, then deactivate the source
	public static function doIndividualsMerge($source, $target)
	{
		if (empty($source) || empty($target)) {
			throw new Exception('Invalid Individuals');
		}
		$transaction = Yii::app()->db->beginTransaction();
		try {
			// process attributes, if source is not empty but this is, replace
			if (empty($target->gender)) {
				$target->gender = $source->gender;
			}
			if (empty($target->image_photo)) {
				$target->image_photo = $source->image_photo;
			}
			if (empty($target->mobile_number)) {
				$target->mobile_number = $source->mobile_number;
			}

			if (empty($target->ic_number)) {
				$target->ic_number = $source->ic_number;
			}
			if (empty($target->text_address_residential)) {
				$target->text_address_residential = $source->text_address_residential;
			}

			if (empty($target->state_code)) {
				$target->state_code = $source->state_code;
			}
			if (empty($target->country_code)) {
				$target->country_code = $source->country_code;
			}
			// process dynamic data
			foreach ($source->_dynamicData as $dt => $dd) {
				if (empty($target->_dynamicData[$dt])) {
					$target->_dynamicData[$dt] = $dd;
				}
			}
			$target->save();

			// process individual2Emails
			// will not merge to target if same email address already exists
			if (!empty($source->individual2Emails)) {
				foreach ($source->individual2Emails as $individual2Email) {
					// if no duplicate
					if (!$target->hasUserEmail($individual2Email->user_email)) {
						$individual2Email->individual_id = $target->id;
						$individual2Email->save();
					}
				}
			}

			// process individualOrganizations
			if (!empty($source->individualOrganizations)) {
				foreach ($source->individualOrganizations as $individualOrganization) {
					// if no duplicate
					if (!$individualOrganization->organization->hasIndividualOrganization($target->id, $individualOrganization->as_role_code)) {
						$individualOrganization->individual_id = $target->id;
						$individualOrganization->save();
					}
				}
			}

			// process persona2Individual
			$sql = sprintf('UPDATE IGNORE persona2individual SET individual_id=%s WHERE individual_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM persona2individual WHERE individual_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// process tag2individual
			$sql = sprintf('UPDATE IGNORE tag2individual SET individual_id=%s WHERE individual_id=%s', $target->id, $source->id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = sprintf('DELETE FROM tag2individual WHERE individual_id=%s', $source->id);
			Yii::app()->db->createCommand($sql)->execute();

			// modularize:
			// instead of getActiveParsableModules, should get all working modules as data in db still need to relink
			$modules = YeeModule::getParsableModules();
			foreach ($modules as $moduleKey => $moduleParams) {
				if (method_exists(Yii::app()->getModule($moduleKey), 'doIndividualsMerge')) {
					list($source, $target) = Yii::app()->getModule($moduleKey)->doIndividualsMerge($source, $target);
				}
			}

			// deactivate source
			$source->is_active = 0;
			$source->save();

			$log = Yii::app()->esLog->log(sprintf("merged and deactivated '%s' into '%s'", $source->full_name, $target->full_name), 'individual', array('trigger' => 'HUB::doIndividualsMerge', 'model' => 'Individual', 'action' => '', 'id' => $source->id, 'individualId' => $source->id));

			$log2 = Yii::app()->esLog->log(sprintf("merged into '%s' from '%s'", $target->full_name, $source->full_name), 'individual', array('trigger' => 'HUB::doIndividualsMerge', 'model' => 'Individual', 'action' => '', 'id' => $target->id, 'individualId' => $target->id));

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $target;
	}

	public static function createIndividualMergeHistory($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$model = new IndividualMergeHistory;
			$model->src_individual_id = $source->id;
			$model->dest_individual_id = $target->id;
			$model->dest_individual_title = $target->full_name;

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

	// return a link of related individual matched by emails and is not currently linked to the organization
	public static function getRelatedEmailIndividual($organization)
	{
		// get all organization2email from organization
		foreach ($organization->organization2Emails as $organization2Email) {
			// find individual that matching these emails
			$individuals = self::getIndividualsByEmail($organization2Email->user_email);
			if (!empty($individuals)) {
				$result[$organization2Email->user_email] = $individuals;
			}
		}

		// exclude those that linked
		foreach ($organization->individuals as $individual) {
			foreach ($individual->verifiedIndividual2Emails as $individual2Email) {
				$linkedEmails[] = $individual2Email->user_email;
			}
		}

		$return = $result;
		if (!empty($linkedEmails)) {
			$return = array_diff_key($result, array_flip($linkedEmails));
		}

		return $return;
	}

	public static function getIndividualsByEmail($userEmail)
	{
		$criteria = new CDbCriteria;
		$criteria->select = 't.*';
		$criteria->join = 'LEFT JOIN `individual2email` AS `i2e` ON t.id = i2e.individual_id';
		$criteria->addCondition('i2e.user_email LIKE :userEmail AND i2e.is_verify=1');
		$criteria->params[':userEmail'] = $userEmail;

		return Individual::model()->findAll($criteria);
	}
}
