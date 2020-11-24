<?php

class HubCv
{
	public function countAllOrganizationCvs($organization)
	{
		//return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
		return 0;
	}

	public function getActiveOrganizationCvs($organization, $limit = 100)
	{
		/*return Comment::model()->findAll(array(
			'condition' => 'object_key=:objectKey AND is_active=1',
			'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
			'limit' => $limit,
			'order' => 'id DESC'
		));*/
		return array();
	}

	public function countAllMemberCvs($member)
	{
		return 0;
	}

	public function getActiveMemberCvs($member, $limit = 100)
	{
		return array();
	}

	public static function getOrCreateCvPortfolio($user, $params = array())
	{
		try {
			$portfolio = self::getCvPortfolioByUser($user);
		} catch (Exception $e) {
			$portfolio = null;
		}

		if ($portfolio === null) {
			$portfolio = self::createCvPortfolio($user, $params);
			$oriModel = clone $portfolio;
		} else {
			$oriModel = clone $portfolio;

			// update attributes
			$portfolio->attributes = $params['cvPortfolio'];

			// convert full address to parts and store
			if (($oriModel->text_address_residential != $portfolio->text_address_residential) && !empty($portfolio->text_address_residential)) {
				$portfolio->resetAddressParts();
			}

			if ($portfolio->save()) {
				UploadManager::storeImage($portfolio, 'avatar', $portfolio->tableName());
			}
		}

		return $portfolio;
	}

	public static function getCvPortfolioByUser($user)
	{
		return CvPortfolio::model()->findByAttributes(array('user_id' => $user->id));
	}

	public static function createCvPortfolio($user, $params = array())
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$portfolio = new CvPortfolio();
			$oriModel = clone $portfolio;
			$portfolio->scenario = 'createCvPortfolio';

			$params['cvPortfolio']['user_id'] = $user->id;
			$portfolio->attributes = $params['cvPortfolio'];
			if (empty($portfolio->display_name)) {
				$portfolio->display_name = !empty($user->profile->full_name) ? $user->profile->full_name : 'User';
			}

			if (!empty(UploadedFile::getInstance($portfolio, 'imageFile_avatar'))) {
				$portfolio->imageFile_avatar = UploadedFile::getInstance($portfolio, 'imageFile_avatar');
			} elseif (!empty($portfolio->urlImageRemote_avatar)) {
				$ruf = new RemoteUploadedFile;
				$ruf->setUrl($portfolio->urlImageRemote_avatar);
				$portfolio->imageRemote_avatar = $ruf;
			} else {
				$portfolio->image_avatar = $portfolio->getDefaultImageAvatar();
			}

			// convert full address to parts and store
			if (($oriModel->text_address_residential != $portfolio->text_address_residential) && !empty($portfolio->text_address_residential)) {
				$portfolio->resetAddressParts();
			}

			if ($portfolio->save()) {
				UploadManager::storeImage($portfolio, 'avatar', $portfolio->tableName());

				RemoteUploadManager::storeImage($portfolio, 'avatar', $portfolio->tableName());

				//$log = Yii::app()->esLog->log(sprintf("'%s' created '%s'", HUB::getSessionUsername(), $organization->title), 'organization', array('trigger' => 'HUB::createOrganization', 'model' => 'Organization', 'action' => 'create', 'id' => $organization->id, 'organizationId' => $organization->id), '', array('userEmail' => $params['userEmail']));

				$transaction->commit();
			} else {
				throw new Exception(YeeBase::modelErrors2String($portfolio->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $portfolio;
	}
}
