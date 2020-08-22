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

// function naming convention: toWho_serviceCode_functionName()
class NotifyMaker
{
	//
	// user
	// to member
	public static function member_user_dataDownloadRequestDone($request, $result)
	{
		$return['title'] = Yii::t('notify', 'Your request to download user data has completed');
		$return['message'] = Yii::t('notify', 'Your request to download user data has completed.');

		$params['dateProcessed'] = Html::formatDateTime($request->jsonArray_data->dateProcessed);
		$params['format'] = strtoupper($request->jsonArray_data->format);
		$params['urlFileDownload'] = $result['data']['url'];
		$params['urlCpanel'] = Yii::app()->createAbsoluteUrl('/cpanel');
		$params['urlDownloadUserData'] = Yii::app()->createAbsoluteUrl('/cpanel/download');
		$params['userIsActive'] = $request->user->is_active;

		// always start with views folder
		$return['content'] = HUB::renderPartial('/emails/_user_dataDownloadRequestDone', $params, true);

		return $return;
	}

	//
	// mentor
	// to mentor
	public static function mentor_mentor_createFuturelabBooking($booking, $customParams)
	{
		$return['title'] = Yii::t('notify', 'You have a new booking request with enquiry!');
		$return['message'] = Yii::t('notify', 'You have a new booking request with enquiry!');

		$params['booking'] = $booking;
		$params['urlManage'] = $customParams['urlManage'];
		$params['companyName'] = $customParams['companyName'];
		$params['enquiry'] = $customParams['enquiry'];

		$return['content'] = Yii::app()->getController()->renderPartial('application.views.emails._mentor_createFuturelabBooking', $params, true);

		return $return;
	}

	//
	// hub
	// to user (or potential user)
	// o2e: Organization2Email
	public static function user_hub_approveEmailAccess($o2e)
	{
		$return['title'] = Yii::t('notify', 'Access to {organizationTitle} has been approved for this email', array('{organizationTitle}' => $o2e->organization->title));

		$return['message'] = Yii::t('notify', 'Access to {organizationTitle} has been approved for this email.', array('{organizationTitle}' => $o2e->organization->title));

		$params['organizationTitle'] = $o2e->organization->title;
		$params['userEmail'] = $o2e->user_email;
		$params['urlLogin'] = Yii::app()->params['connectUrl'];
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $o2e->organization->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.views.emails._user_approveEmailAccess', $params, true);

		return $return;
	}

	// to user (or potential user)
	// o2e: Organization2Email
	// todo: detach MaGIC Connect
	public static function user_hub_revokeEmailAccess($o2e)
	{
		$return['title'] = Yii::t('notify', 'Access to {organizationTitle} has been rejected/revoked for this email', array('{organizationTitle}' => $o2e->organization->title));

		$return['message'] = Yii::t('notify', 'Access to {organizationTitle} has been rejected/revoked for this email.', array('{organizationTitle}' => $o2e->organization->title));

		$params['organizationTitle'] = $o2e->organization->title;
		$params['userEmail'] = $o2e->user_email;
		$params['urlLogin'] = Yii::app()->params['connectUrl'];
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $o2e->organization->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.views.emails._user_revokeEmailAccess', $params, true);

		return $return;
	}

	//
	// sea
	// basic
	public static function organization_submitSeaFormBasic($organization, $seaFormBasic, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', "[SE.A] Enterprise '{title}' is now being reviewed for SE Basic status", array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $seaFormBasic->code;
		$params['userEmail'] = $userEmail;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.sea.views._email.organization_submitSeaFormBasic', $params, true);

		return $return;
	}

	public static function admin_approveSeaFormBasic($organization, $seaFormBasic, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', "[SE.A] Enterprise '{title}' SE Basic Status approved", array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $seaFormBasic->code;
		$params['userEmail'] = $userEmail;
		$params['urlManageSe'] = Yii::app()->createAbsoluteUrl('//sea/frontend/manage');
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.sea.views._email.admin_approveSeaFormBasic', $params, true);

		return $return;
	}

	// standard
	public static function organization_submitSeaFormStandard($organization, $seaFormBasic, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', "[SE.A] Enterprise '{title}' is now being reviewed for SE.A status", array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $seaFormBasic->code;
		$params['userEmail'] = $userEmail;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.sea.views._email.organization_submitSeaFormStandard', $params, true);

		return $return;
	}

	public static function admin_approveSeaFormStandard($organization, $seaFormStandard, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', "[SE.A] '{title}' Social Enterprise Accreditation (SE.A) Status approved", array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $seaFormStandard->code;
		$params['userEmail'] = $userEmail;
		$params['urlManageSe'] = Yii::app()->createAbsoluteUrl('//sea/frontend/manage');
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.sea.views._email.admin_approveSeaFormStandard', $params, true);

		return $return;
	}

	public static function admin_rejectSeaFormStandard($organization, $seaFormStandard, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', "[SE.A] '{title}' Social Enterprise Accreditation (SE.A) Results", array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $seaFormStandard->code;
		$params['userEmail'] = $userEmail;
		$params['urlManageSe'] = Yii::app()->createAbsoluteUrl('//sea/frontend/manage');
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.sea.views._email.admin_rejectSeaFormStandard', $params, true);

		return $return;
	}

	//
	// idea rfp
	// to creator: partner
	public static function organization_idea_createRfp($rfp, $partner)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$params['date'] = Html::formatDateTime($rfp->date_added);
		$params['title'] = $rfp->title;
		$params['partnerTitle'] = $partner->title;
		$params['partnerEmail'] = $partner->email;

		$params['content'] = $rfp->html_content;
		$params['textBg'] = $rfp->text_background;
		$params['textScope'] = $rfp->text_scope;
		$params['textSchedule'] = $rfp->text_schedule;
		$params['textBudget'] = $rfp->text_cost;
		$params['textSupportingInfo'] = $rfp->text_supporting;

		$params['enterprises'] = $rfp->enterprises;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_createRfp', $params, true);

		return $return;
	}

	// NOTE: not using
	// to admin: idea team
	public static function admin_idea_createRfp($rfp, $partner)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$params['date'] = Html::formatDateTime($rfp->date_added);
		$params['title'] = $rfp->title;
		$params['partnerTitle'] = $partner->title;
		$params['partnerEmail'] = $partner->email;

		$params['content'] = $rfp->html_content;
		$params['textBg'] = $rfp->text_background;
		$params['textScope'] = $rfp->text_scope;
		$params['textSchedule'] = $rfp->text_schedule;
		$params['textBudget'] = $rfp->text_cost;
		$params['textSupportingInfo'] = $rfp->text_supporting;

		$params['enterprises'] = $rfp->enterprises;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.admin_createRfp', $params, true);

		return $return;
	}

	//
	// createEnterprise
	// to admin: idea team
	public static function admin_idea_createEnterprise($enterprise, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Enterprise '{title}' created", array('{title}' => $enterprise->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Enterprise '{title}' created", array('{title}' => $enterprise->title));

		$params['date'] = Html::formatDateTime($enterprise->date_added);
		$params['title'] = $enterprise->title;
		$params['userEmail'] = $userEmail;
		$params['urlAdmin'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $enterprise->id, 'realm' => 'backend'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.admin_createEnterprise', $params, true);

		return $return;
	}

	// to user
	public static function user_idea_createEnterprise($enterprise, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] You have created new Enterprise '{title}'", array('{title}' => $enterprise->title));

		$return['message'] = Yii::t('notify', "[IDEA] You have created new Enterprise '{title}'", array('{title}' => $enterprise->title));

		$params['date'] = Html::formatDateTime($enterprise->date_added);
		$params['title'] = $enterprise->title;
		$params['userEmail'] = $userEmail;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $enterprise->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.user_createEnterprise', $params, true);

		return $return;
	}

	// to organization
	public static function organization_idea_createEnterprise($enterprise, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Enterprise '{title}' created", array('{title}' => $enterprise->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Enterprise '{title}' created", array('{title}' => $enterprise->title));

		$params['date'] = Html::formatDateTime($enterprise->date_added);
		$params['title'] = $enterprise->title;
		$params['userEmail'] = $userEmail;
		$params['appName'] = Yii::app()->name;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_createEnterprise', $params, true);

		return $return;
	}

	//
	// createPartner
	// to admin: idea team
	public static function admin_idea_createPartner($partner, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Partner '{title}' created", array('{title}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Partner '{title}' created", array('{title}' => $partner->title));

		$params['date'] = Html::formatDateTime($partner->date_added);
		$params['title'] = $partner->title;
		$params['userEmail'] = $userEmail;
		$params['urlAdmin'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $partner->id, 'realm' => 'backend'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.admin_createPartner', $params, true);

		return $return;
	}

	// to user
	public static function user_idea_createPartner($partner, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] You have created new Partner '{title}'", array('{title}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] You have created new Partner '{title}'", array('{title}' => $partner->title));

		$params['date'] = Html::formatDateTime($partner->date_added);
		$params['title'] = $partner->title;
		$params['userEmail'] = $userEmail;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $partner->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.user_createPartner', $params, true);

		return $return;
	}

	// to organization
	public static function organization_idea_createPartner($partner, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Partner '{title}' created", array('{title}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Partner '{title}' created", array('{title}' => $partner->title));

		$params['date'] = Html::formatDateTime($partner->date_added);
		$params['title'] = $partner->title;
		$params['userEmail'] = $userEmail;
		$params['appName'] = Yii::app()->name;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_createPartner', $params, true);

		return $return;
	}

	//
	// createOrganization
	// to admin: idea team
	public static function admin_idea_createOrganization($organization, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Organization '{title}' created", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Organization '{title}' created", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['urlAdmin'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $organization->id, 'realm' => 'backend'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.admin_createOrganization', $params, true);

		return $return;
	}

	// to user
	public static function user_idea_createOrganization($organization, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] You have created new Organization '{title}'", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] You have created new Organization '{title}'", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $organization->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.user_createOrganization', $params, true);

		return $return;
	}

	// to organization
	public static function organization_idea_createOrganization($organization, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New Organization '{title}' created", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] New Organization '{title}' created", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['appName'] = Yii::app()->name;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_createOrganization', $params, true);

		return $return;
	}

	//
	// sendRfp
	// to receiver: various enterprises
	public static function organization_idea_sendRfp($rfp, $enterprise, $partner)
	{
		$return['title'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] New RFP '{rfpTitle}' from {partnerTitle}", array('{rfpTitle}' => $rfp->title, '{partnerTitle}' => $partner->title));

		$params['date'] = Html::formatDateTime($rfp->date_added);
		$params['title'] = $rfp->title;
		$params['partnerTitle'] = $partner->title;
		$params['partnerEmail'] = $partner->email;

		$params['content'] = $rfp->html_content;
		$params['textBg'] = $rfp->text_background;
		$params['textScope'] = $rfp->text_scope;
		$params['textSchedule'] = $rfp->text_schedule;
		$params['textStaff'] = $rfp->text_staff;
		$params['textBudget'] = $rfp->text_cost;
		$params['textSupportingInfo'] = $rfp->text_supporting;

		$params['enterpriseTitle'] = $enterprise->title;
		$params['enterpriseEmail'] = $enterprise->email;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_sendRfp', $params, true);

		return $return;
	}

	//
	// enterprise application approved
	// to organization
	public static function organization_idea_enterpriseApplicationApproved($enterprise)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Enterprise '{title}' is now approved", array('{title}' => $enterprise->title));

		$return['message'] = Yii::t('notify', "[IDEA] Enterprise '{title}' is now approved", array('{title}' => $enterprise->title));

		$params['date'] = Html::formatDateTime(time());
		$params['title'] = $enterprise->title;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_enterpriseApplicationApproved', $params, true);

		return $return;
	}

	//
	// partner application approved
	// to organization
	public static function organization_idea_partnerApplicationApproved($partner)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Partner '{title}' is now approved", array('{title}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] Partner '{title}' is now approved", array('{title}' => $partner->title));

		$params['date'] = Html::formatDateTime(time());
		$params['title'] = $partner->title;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_partnerApplicationApproved', $params, true);

		return $return;
	}

	//
	// enterprise enrollment removed
	// to organization
	public static function organization_idea_enterpriseRemoved($enterprise)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Enterprise '{title}' is now removed", array('{title}' => $enterprise->title));

		$return['message'] = Yii::t('notify', "[IDEA] Enterprise '{title}' is now removed", array('{title}' => $enterprise->title));

		$params['date'] = Html::formatDateTime(time());
		$params['title'] = $enterprise->title;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_enterpriseRemoved', $params, true);

		return $return;
	}

	//
	// partner enrollment removed
	// to organization
	public static function organization_idea_partnerRemoved($partner)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Partner '{title}' is now removed", array('{title}' => $partner->title));

		$return['message'] = Yii::t('notify', "[IDEA] Partner '{title}' is now removed", array('{title}' => $partner->title));

		$params['date'] = Html::formatDateTime(time());
		$params['title'] = $partner->title;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_partnerRemoved', $params, true);

		return $return;
	}

	//
	// enterprise membership upgraded
	// to organization
	public static function organization_idea_enterpriseMembershipUpgraded($enterprise)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Enterprise '{title}' membership has been upgraded to {membership}", array('{title}' => $enterprise->title, '{membership}' => $enterprise->renderIdeaEnterpriseMembership()));

		$return['message'] = Yii::t('notify', "[IDEA] Enterprise '{title}' membership has been upgraded to {membership}", array('{title}' => $enterprise->title, '{membership}' => $enterprise->renderIdeaEnterpriseMembership()));

		$params['date'] = Html::formatDateTime(time());
		$params['membership'] = $enterprise->renderIdeaEnterpriseMembership();
		$params['title'] = $enterprise->title;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $enterprise->id));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_enterpriseMembershipUpgraded', $params, true);

		return $return;
	}

	//
	// enterprise membership downgraded
	// to organization
	public static function organization_idea_enterpriseMembershipDowngraded($enterprise)
	{
		$return['title'] = Yii::t('notify', "[IDEA] Enterprise '{title}' membership has been downgraded to {membership}", array('{title}' => $enterprise->title, '{membership}' => $enterprise->renderIdeaEnterpriseMembership()));

		$return['message'] = Yii::t('notify', "[IDEA] Enterprise '{title}' membership has been downgraded to {membership}", array('{title}' => $enterprise->title, '{membership}' => $enterprise->renderIdeaEnterpriseMembership()));

		$params['date'] = Html::formatDateTime(time());
		$params['membership'] = $enterprise->renderIdeaEnterpriseMembership();
		$params['title'] = $enterprise->title;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $enterprise->id));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_enterpriseMembershipDowngraded', $params, true);

		return $return;
	}

	//
	// applyAccreditation
	// @alif: new
	// to admin: idea team
	public static function admin_idea_applyAccreditation($organization, $userEmail = '')
	{
		$return['title'] = Yii::t('notify', "[IDEA] '{title}' apply for IDEA accreditation", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] '{title}' apply for IDEA accreditation", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['urlAdmin'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $organization->id, 'realm' => 'backend'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.admin_applyAccreditation', $params, true);

		return $return;
	}

	// to user
	public static function user_idea_applyAccreditation($organization, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] You have applied IDEA accreditation for '{title}'", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] You have applied IDEA accreditation for '{title}'", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['urlManage'] = Yii::app()->createAbsoluteUrl('//organization/view', array('id' => $organization->id, 'realm' => 'cpanel'));
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.user_applyAccreditation', $params, true);

		return $return;
	}

	// to organization
	public static function organization_idea_applyAccreditation($organization, $userEmail)
	{
		$return['title'] = Yii::t('notify', "[IDEA] '{title}' apply for IDEA accreditation", array('{title}' => $organization->title));

		$return['message'] = Yii::t('notify', "[IDEA] '{title}' apply for IDEA accreditation", array('{title}' => $organization->title));

		$params['date'] = Html::formatDateTime($organization->date_added);
		$params['title'] = $organization->title;
		$params['userEmail'] = $userEmail;
		$params['appName'] = Yii::app()->name;
		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.idea.views._email.organization_applyAccreditation', $params, true);

		return $return;
	}

	public static function member_user_accountTerminationDone()
	{
		$params = array();
		$return['title'] = Yii::t('notify', 'Your account has been terminated');
		$return['message'] = Yii::t('notify', 'Your account has been terminated.');

		// always start with views folder
		$return['content'] = HUB::renderPartial('/emails/_terminateAccount', $params, true);

		return $return;
	}

	public static function event_sendPostEventSurvey1Day($eventTitle, $eventId, $firstName, $urlSurveyForm)
	{
		$return['title'] = Yii::t('notify', "Thank for attending '{eventTitle}' session", array('{eventTitle}' => $eventTitle));

		$return['message'] = Yii::t('notify', "Thank for attending “'{eventTitle}'” session", array('{eventTitle}' => $eventTitle));

		$params['eventTitle'] = $eventTitle;
		$params['firstName'] = $firstName;
		$params['urlSurveyForm'] = $urlSurveyForm;

		// always start with views folder
		$return['content'] = HUB::renderPartial('/emails/_event_sendPostEventSurvey1Day', $params, true);

		return $return;
	}

	public static function event_sendPostEventSurvey6Months($eventTitle, $eventId, $firstName, $urlSurveyForm)
	{
		$return['title'] = Yii::t('notify', "Follow up on '{eventTitle}' session", array('{eventTitle}' => $eventTitle));

		$return['message'] = Yii::t('notify', "Follow up on '{eventTitle}' session", array('{eventTitle}' => $eventTitle));

		$params['eventTitle'] = $eventTitle;
		$params['firstName'] = $firstName;
		$params['urlSurveyForm'] = $urlSurveyForm;

		// always start with views folder
		$return['content'] = HUB::renderPartial('/emails/_event_sendPostEventSurvey6Months', $params, true);

		return $return;
	}

	// This function is to replace placeholders in the views with variables
	public static function organization_submitNtisForm($organization, $ntisFormSolution, $userEmail, $scoring = 99)
	{
		// Declare contents
		$S1CapacityProgrammes = 'MaGIC Bootcamp, MaGIC workshop, MaGIC Grill & Chill and etc ';
		$S1Agency = 'Malaysian Global Innovation & Creativity Centre';
		$S2CapacityProgrammes = 'TPM Innovation Incubation Centre';
		$S2Agency = 'Technology Park Malaysia(TPM)';

		$return['title'] = $return['message'] = Yii::t('notify', 'Thanks for your submission', array('{title}' => $organization->title));

		// variables in the email to be declared and passed here. Check Yuan's document.
		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['userEmail'] = $userEmail;

		// REJECTED
		if ($scoring == 1) {
			$params['capacityProgrammes'] = $S1CapacityProgrammes;
			$params['agency'] = $S1Agency;
			$return['title'] = 'NTIS Application Status Result';
			$return['content'] = Yii::app()->getController()->renderPartial('application.modules.ntis.views._email.admin_rejectNtisFormSolution', $params, true);
			// REJECTED
		} elseif ($scoring == 2) {
			$params['capacityProgrammes'] = $S2CapacityProgrammes;
			$params['agency'] = $S2Agency;
			$return['title'] = 'NTIS Application Status Result';
			$return['content'] = Yii::app()->getController()->renderPartial('application.modules.ntis.views._email.admin_rejectNtisFormSolution', $params, true);
		} else {
			$return['content'] = Yii::app()->getController()->renderPartial('application.modules.ntis.views._email.admin_approveNtisFormSolution', $params, true);
		}

		return $return;
	}

	public static function organization_reminderNtisForm($organization, $ntisFormSolution, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', 'Reminder for Application Submission', array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['userEmail'] = $userEmail;

		$return['content'] = Yii::app()->getController()->renderPartial('application.modules.ntis.views._email.admin_reminderNtisFormSolution', $params, true);

		return $return;
	}

	/**
	 * this function may be called in NtisFormSolutionController or cron
	 * @param object $organization model Organization
	 * @param object $ntisFormSolution model NtisFormSolution
	 * @param string $userEmail recipient email
	 *
	 * @return array
	 */
	public static function admin_applicationProcessNtisFormSolution($organization, $ntisFormSolution, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', 'NTIS Application Status Update');

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['userEmail'] = $userEmail;

		if (isset(Yii::app()->controller)) {
			$pathFile = 'application.modules.ntis.views._email.';
		} else {
			$pathFile = '/../modules/ntis/views/_email/';
		}

		$return['content'] = HUB::renderPartial($pathFile . 'admin_applicationProcessNtisFormSolution', $params, true);

		return $return;
	}

	/**
	 * this function may be called in NtisFormSolutionController or cron
	 * @param object $organization model Organization
	 * @param object $ntisFormSolution model NtisFormSolution
	 * @param string $userEmail recipient email
	 *
	 * @return array
	 */
	public static function admin_applicationRejectNtisFormSolution($organization, $ntisFormSolution, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', 'NTIS Application Status Result');

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['cohortNo'] = HubNtis::getCohortNo($ntisFormSolution->batch_key);
		$params['userEmail'] = $userEmail;

		if (isset(Yii::app()->controller)) {
			$pathFile = 'application.modules.ntis.views._email.';
		} else {
			$pathFile = '/../modules/ntis/views/_email/';
		}

		$return['content'] = HUB::renderPartial($pathFile . 'admin_applicationRejectNtisFormSolution', $params, true);

		return $return;
	}

	/**
	 * this function called in NtisFormSolutionController
	 * @param object $organization model Organization
	 * @param object $ntisFormSolution model NtisFormSolution
	 * @param string $userEmail recipient email
	 *
	 * @return array
	 */
	public static function admin_commentNtisFormSolution($organization, $ntisFormSolution, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', 'Notification for Comment');

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['userEmail'] = $userEmail;

		$return['content'] = HUB::renderPartial('application.modules.ntis.views._email.admin_commentNtisFormSolution', $params, true);

		return $return;
	}

	/**
	 * this function called in NtisFormSolutionController::actionEndorseEsc
	 * @param object $organization model Organization
	 * @param object $ntisFormSolution model NtisFormSolution
	 * @param string $userEmail recipient email
	 *
	 * @return array
	 */
	public static function organization_endorseNtisForm($organization, $ntisFormSolution, $userEmail)
	{
		$return['title'] = $return['message'] = Yii::t('notify', 'Thanks for your submission', array('{title}' => $organization->title));

		$params['organizationTitle'] = $organization->title;
		$params['applicationSerialNo'] = $ntisFormSolution->code;
		$params['userEmail'] = $userEmail;

		if ($ntisFormSolution->getSecretariatDecision() == 'accept') {
			$params['sandbox'] = $ntisFormSolution->formatEnumStatus($ntisFormSolution->esc_sandbox);
			$return['title'] = 'NTIS Screening Status Update';
			$return['content'] = HUB::renderPartial('application.modules.ntis.views._email.admin_endorseAcceptNtisFormSolution', $params, true);
		} else { // reject
			$params['reason'] = NtisActionLog::getMessageByActionStatus($ntisFormSolution, 'esc-not-for-sandbox');
			// $params['reason'] = $ntisFormSolution->text_note;
			$return['title'] = 'NTIS Screening Status Result';
			$return['content'] = HUB::renderPartial('application.modules.ntis.views._email.admin_endorseRejectNtisFormSolution', $params, true);
		}

		return $return;
	}
}
