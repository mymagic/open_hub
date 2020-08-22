<?php

class HubChallenge
{
	public function countAllOrganizationChallenges($organization)
	{
		//return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
		return 0;
	}

	public function getActiveOrganizationChallenges($organization, $limit = 100)
	{
		/*return Comment::model()->findAll(array(
			'condition' => 'object_key=:objectKey AND is_active=1',
			'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
			'limit' => $limit,
			'order' => 'id DESC'
		));*/
		return array();
	}

	// call when challenge status=approved
	// create/update f7 form if not exists and link
	// pass in challenge model
	public function createOrUpdateF7Form($challenge)
	{
		// create intake if not exists
		$intake = HubForm::getOrCreateIntake($challenge->title, array());
		$intake->text_short_description = $challenge->text_short_description;
		$intake->date_started = $challenge->date_open;
		$intake->date_ended = $challenge->date_close;
		$intake->is_active = $challenge->is_active;
		$intake->save();

		// todo: use meta to link intake to challenge

		// create form if intake is empty from template
		// template code:
		$templateForm = Form::model()->slug2obj(Yii::app()->getModule('challenge')->f7TemplateFormSlug);

		// find existing or create new if not found
		// update form detail:
		$form = HubForm::getOrCreateIntakeForm($intake->id, 'Apply to Challenge');
		$form->type = $templateForm->type;
		$form->text_note = $templateForm->text_note;
		$form->timezone = $templateForm->timezone;
		$form->is_active = $templateForm->is_active;
		$form->is_login_required = $templateForm->is_login_required;
		$form->is_multiple = $templateForm->is_multiple;
		$form->jsonArray_stage = $templateForm->jsonArray_stage;
		$form->jsonArray_structure = $templateForm->jsonArray_structure;
		$form->date_open = $templateForm->date_open;
		$form->date_close = $templateForm->date_close;
		$form->slug = '';

		// override form attribute with challenge
		// slug, date_open, date_close, title, text_short_description, timezone
		$form->title = 'Apply to Challenge';
		$form->slug = ysUtil::slugify($challenge->title);
		$form->text_short_description = '';
		$form->date_open = $challenge->date_open;
		$form->date_close = $challenge->date_close;
		$form->timezone = $challenge->timezone;
		$form->save();

		// update form url back to challenge
		$challenge->url_application_form = $form->getPublicUrl();
		$challenge->save();

		// create form2intake
		$form2Intake = HubForm::getOrCreateForm2Intake($intake->id, $form->id);

		return $form;
	}

	public static function getOrCreateChallenge($title, $creatorUserId, $ownerOrganizationId, $params = array())
	{
		try {
			$challenge = self::getChallengeByTitle($title);
		} catch (Exception $e) {
			$challenge = self::createChallenge($title, $creatorUserId, $ownerOrganizationId, $params);
		}

		return $challenge;
	}

	public static function getChallengeByTitle($title)
	{
		$model = Challenge::model()->title2obj($title);
		if ($model === null) {
			throw new CHttpException(404, 'The requested challenge does not exist.');
		}

		return $model;
	}

	public static function createChallenge($title, $creatorUserId, $ownerOrganizationId, $params = array())
	{
		$challenge = new Challenge();
		$challenge->title = $title;
		$challenge->creator_user_id = $creatorUserId;
		$challenge->owner_organization_id = $ownerOrganizationId;
		$challenge->save();

		return $challenge;
	}
}
