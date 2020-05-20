<?php

// this file should not be open source

use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\ElasticsearchService\ElasticsearchPhpHandler;
use Elasticsearch\ClientBuilder;
use wadeshuler\paypalipn\IpnListener;
use mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \DrewM\MailChimp\MailChimp;
use Composer\Semver\Comparator;
use Composer\Semver\Semver;
use Intervention\HttpAuth\HttpAuth;

class TestController extends Controller
{
	public $layout = 'frontend';

	public function actionIndex()
	{
		//if you want to use reflection
		$reflection = new ReflectionClass('TestController');
		$methods = $reflection->getMethods();
		$actions = array();
		foreach ($methods as $method) {
			if (substr($method->name, 0, 6) == 'action' && $method->name != 'actionIndex' && $method->name != 'actions') {
				$methodName4Url = lcfirst(substr($method->name, 6));
				$actions[] = $methodName4Url;
			}
		}

		$this->render('index', array('actions' => $actions));
	}

	public function actionUi()
	{
		$this->render('ui');
	}

	public function actionGetIndividualsByEmail()
	{
		print_r(HubIndividual::getIndividualsByEmail('erlich@piedpiper.com'));
		exit;
	}

	public function actionGetRelatedEmailIndividual()
	{
		$organization = HubOrganization::getOrCreateOrganization('Pied Piper');
		$result = HubIndividual::getRelatedEmailIndividual($organization);
		foreach ($result as $email => $individuals) {
			echo '<h3>' . $email . '</h3>';
			echo '<ol>';
			foreach ($individuals as $individual) {
				echo sprintf('<li>%s</li>', $individual->full_name) ;
			}
			echo '</ol>';
		}
		exit;
	}

	public function actionPhpHttpAuth()
	{
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'Text to send if user hits Cancel button';
			exit;
		} else {
			echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
			echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
		}
	}

	public function actionHttpAuth()
	{
		$config = array(
			'type' => 'basic',
			'realm' => 'test',
			'username' => 'admin',
			'password' => '123456',
		);
		$httpauth = HttpAuth::make($config);
		$httpauth->secure();

		echo 'Access Granted';
	}

	public function actionGetVersion()
	{
		echo $this->getVersion();
	}

	public function actionOutputJson()
	{
		$meta['input']['var1FromPost'] = 'abc';
		$meta['input']['var2FromPost'] = 'def';
		$meta['input']['output']['total'] = 2;

		$data[] = array('orderId' => '99', 'productTitle' => '4K LED TV', 'deliveryLocation' => 'Cyberjaya, Malaysia', 'buyerName' => 'Allen Tan');
		$data[] = array('orderId' => '88', 'productTitle' => 'Playstation 4', 'deliveryLocation' => 'KLIA, Malaysia', 'buyerName' => 'Foo Bar');

		$this->outputJson($data, 'Everything works fine', 'success', $meta);
	}

	public function actionOrganizationScore($id)
	{
		$organization = Organization::model()->findByPk($id);
		$organization->save();
		$score = $organization->calcProfileCompletenessScore();
		print_r($organization->toApi());
		print_r($score);
	}

	public function actionIndividualScore($id)
	{
		$individual = Individual::model()->findByPk($id);
		$individual->save();
		$score = $individual->calcProfileCompletenessScore();
		print_r($individual->toApi());
		print_r($score);
	}

	public function actionOrganizationMeta($id)
	{
		echo '<pre>';
		$org = Organization::model()->findByPk($id);
		echo 'When Loaded';
		print_r($org->_dynamicData);
		$org->_dynamicData['Organization-status-isBumi'] = 1;
		$org->save();
		echo 'After Saved';
		print_r($org->_dynamicData);
	}

	public function actionActiveParsableModule()
	{
		$tmps = YeeModule::getActiveParsableModules();
		echo '<pre>';
		print_r($tmps);
	}

	public function actionAddressBreakdown()
	{
		$address = 'No 642-B, Jalan Yong Pak Khian, Taman Nam Yang, Ujong Pasir, 75050, Melaka, Malaysia';
		$parts = HubGeo::geocoder2AddressParts(HubGeo::address2Geocoder($address));
		echo '<pre>';
		print_r($parts);
	}

	public function actionMemberSystemActFeed()
	{
		$tmps = HubMember::getSystemActFeed('2018-05-01', '2018-05-07');
		echo '<pre>';
		print_r($tmps);
	}

	public function actionCurlWapi()
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getEsLogs',
			[
				'form_params' => [
					'page' => 1,
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

	public function actionGetMainUrl()
	{
		$url = getenv('BASE_API_URL');
		echo $url;
		$parsed = parse_url($url);
		print_r($parsed);
		$result = sprintf('%s://%s', $parsed['scheme'], $parsed['host']);
		echo $result;
	}

	public function actionF7Model()
	{
		$startupStages = array_map(create_function('$t', 'return $t[title];'), StartupStage::model()->isActive()->findAll(array('order' => 'ordering ASC')));

		print_r($startupStages);
		exit;
	}

	public function actionResetUserPassword($username, $password)
	{
		$username = rawurldecode($username);
		$user = User::username2obj($username);
		$user->password = $password;
		$user->save();

		echo sprintf("reset user '%s' to %s -> %s", $username, $password, $user->password);
	}

	public function actionMatchUserPassword($username, $password)
	{
		$username = rawurldecode($username);
		$user = User::username2obj($username);
		echo sprintf('Match: %s', $user->matchPassword($password));
	}

	public function actionCreateUserPassword($username, $password)
	{
		$username = rawurldecode($username);
		$user = new User;
		$user->username = $username;
		$user->password = $password;
		$user->signup_type = 'admin';
		$user->signup_ip = Yii::app()->request->userHostAddress;
		$user->is_active = 1;
		$user->save();

		echo $user->username;
	}

	public function actionPasswordHash()
	{
		$password = '123456';
		$salt = sprintf('%s.%s', 'exiang83@yahoo.com', Yii::app()->params['saltSecret']);

		$sha1 = sha1($password);
		echo sprintf('SHA1: %s<br>', $sha1);
		$bcryptHashed = password_hash(hash_hmac('sha256', $password, $salt), PASSWORD_BCRYPT);
		echo sprintf('BCRYPT HASHED: %s<br>', $bcryptHashed);

		echo sprintf('Match: %s', password_verify(hash_hmac('sha256', $password, $salt), $bcryptHashed));
	}

	// attach event to activeRecord model after saved
	public function actionJunkCreatedHook()
	{
		$j = new Junk;
		$j->code = 'test-junkAfterSave-' . time();
		$j->content = 'test-junkAfterSave-' . time();
		// use the default event in model
		$j->onAfterSave->add(function () {
			echo " onAftersave event raised, custom function 1 called\n";
		});
		// use the custom event in model
		$j->onJunkCreated->add(function () {
			echo " onJunkCreated event raised, custom function 2 called\n";
		});
		$j->save();
		echo sprintf('<p>id: %s</p>', $j->id);
	}

	public function actionJunkSavedHook($id)
	{
		if (empty($id)) {
			echo 'Please provide id in GET';
		}

		$j = Junk::model()->findByPk($id);
		$j->content = 'changed on' . time();
		// use the default event in model
		$j->onAfterSave->add(function () {
			echo " onAftersave event raised, custom function 1 called\n";
		});
		// this event should not be triggered since it is an existing record
		$j->onJunkCreated->add(function () {
			echo " onJunkCreated event raised, custom function 2 called\n";
		});
		$j->save();
	}

	public function actionGetThumbnailSetting()
	{
		echo '<pre>';
		print_r(Yii::app()->params['thumbnails']);
	}

	public function actionEsLogCreateOrganizationStat()
	{
		$minTimestamp = strtotime('01 jan 2018');
		$maxTimestamp = strtotime('01 jan 2020');
		$index = Yii::app()->params['esLogIndexCode'];
		//$index = 'log-central';

		$params = [
			'index' => $index,
			'size' => 1000,
			'body' => [
				'query' => [
					'bool' => [
						'must' => [
							['match' => ['model' => 'Organization']],
							['match' => ['action' => 'create']],
							/*['range' => [
								'dateLog' => [
									"gte" => $minTimestamp,
									"lte" => $maxTimestamp
								]
							]],*/
						]
					],
				],
				'sort' => [
					'dateLog' => ['order' => 'desc']
				]
			]
		];
		$response = Yii::app()->esLog->getClient()->search($params);
		foreach ($response['hits']['hits'] as $r) {
			echo sprintf('%s %s on %s<br />', $r['_source']['username'], $r['_source']['msg'], date('Y-m-d', $r['_source']['dateLog']));
		}
	}

	public function actionConvertTableName2Class()
	{
		$refTable = 'event_registration';
		//$refTable = 'organization_funding2individual';

		$codeTable = str_replace('_', ' ', $refTable);
		$codeTable = str_replace(' ', '', ucwords($codeTable));

		echo $codeTable;
	}

	public function actionPersona4Startup($page = 1)
	{
		$filter['persona'] = 'startups';
		// find all company with startup persona
		$result = HubOrganization::getOrganizationAllActive($page, $filter, 30);
		//echo '<pre>';print_r($result['items']);exit;
		echo sprintf('<ol start="%s">', (($page - 1) * 30) + 1);
		foreach ($result['items'] as $startup) {
			echo sprintf('<li>%s</li>', $startup->title);
		}
		echo '</ol>';
		echo sprintf('<a href="%s">Next Page</a>', $this->createUrl('test/persona4Startup', array('page' => $page + 1)));
	}

	public function actionSematicVersion()
	{
		echo '<pre>';

		$moduleKey = 'sample';
		print_r(YeeModule::updateModule($moduleKey));
	}

	public function actionCalcMentorOverallRating()
	{
		$return = HubMentor::convertRating2Star(HubMentor::calcMentorOverallRating(1701, 34));
		print_r($return);
	}

	public function actionIndividualComments()
	{
		$idv = Individual::model()->findByPk(6847);
		echo $idv->countAllComments();
		echo '<pre>';
		print_r($idv->getActiveComments(1));
	}

	public function actionOrganizationComments()
	{
		//echo '<pre>';print_r(Yii::app()->modules);exit;
		//echo '<pre>';print_r(Yii::app()->getModule('comment')->modelBehaviors);exit;
		echo Yii::app()->getModule('comment')->abc;
		$org = Organization::model()->findByPk(3582);
		echo $org->countAllComments();
		echo '<pre>';
		print_r($org->getActiveComments(1));
	}

	public function actionGetResourceCategories()
	{
		$tmps = HubResource::getGeofocuses();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$childs = array();
				if (!empty($tmp['childs'])) {
					foreach ($tmp['childs'] as $child) {
						$childs[] = $child->toApi();
					}
					$tmp['childs'] = $childs;
				}
				$result[] = $tmp;
			}
		}

		print_r($result);
	}

	public function actionGetAvailableSlotsRecently()
	{
		//$tmps = HubFuturelab::getAvailableSlotsRecently(1745, 32, 'Asia/Kuala_Lumpur');
		//$tmps = HubFuturelab::getAvailableSlotsRecently(1745, 32, 'Asia/Bangkok');
		//$tmps = HubFuturelab::getAvailableSlotsRecently(1745, 32, 'Europe/London');
		//$tmps = HubFuturelab::getAvailableSlotsRecently(1745, 32, 'Pacific/Auckland');
		$tmps = HubFuturelab::getAvailableSlotsRecently(1745, 32, 'America/New_York');
		echo '<pre>';
		print_r($tmps);
		exit;
	}

	public function actionFbCustomer()
	{
		$this->render('fbCustomer');
	}

	/*Array
	(
		[line1] => 19A-2 Jalan BBU 2
		[line2] => Taman Bukit Beruang Utama, Bukit Beruang
		[city] => Bukit Beruang
		[zipcode] => 75450
		[state] => Melaka
		[countryCode] => MY
		[countryName] => Malaysia
		[lat] => 2.2531202
		[lng] => 102.2761449
		[fullAddress] => 19A-2 Jalan BBU 2, Taman Bukit Beruang Utama, Bukit Beruang, 75450, Melaka, Malaysia
	)*/

	public function actionResetAllOrganizationAddressParts()
	{
		$sql = "SELECT * FROM `organization` WHERE full_address != '' AND is_active=1 LIMIT 0, 400";
		//$orgs = Organization::model()->isActive()->findAll();
		$orgs = Organization::model()->findAllBySql($sql);

		foreach ($orgs as $org) {
			echo sprintf('%s - %s<br />', $org->title, $org->full_address);
			$org->resetAddressParts();
			$org->save(false);
		}
	}

	public function actionBreakFullAddress()
	{
		//$address = '19A-2, Jalan BBU 2, Taman Bukit Beruang Utama, 75450 Bukit Beruang, Melaka, Malaysia';
		$address = '128, JLN WARISAN INDAH 8/16, Kota Warisan, 43900 Selangor, Malaysia';

		$geocoder = HubGeo::address2Geocoder($address);
		$result = HubGeo::geocoder2AddressParts($geocoder);

		print_r($result);
	}

	public function actionSendSurvey()
	{
		$surveyType = '1Day';
		$eventTitle = 'Test Event';
		$eventId = 50311;
		$firstName = 'Allen';
		$fullName = 'Allen Tan';
		$email = 'exiang83@yahoo.com';

		$urlSurveyForm = HubEvent::getSurveyFormUrl($eventId, $surveyType);

		$notifyMaker = NotifyMaker::event_sendPostEventSurvey1Day($eventTitle, $eventId, $firstName, $urlSurveyForm);
		print_r($notifyMaker);
		exit;
		$result = HUB::sendEmail($email, $fullName, $notifyMaker['title'], $notifyMaker['content']);
	}

	public function actionListPartnersLogo()
	{
		echo '<pre>';
		$tmp = HubIdea::listPartnersLogo();
		//print_r($tmp);
		foreach ($tmp as $t) {
			echo sprintf('<li>%s <img src="%s" width="100px" /></li>', $t->title, $t->getImageLogoUrl());
		}
	}

	public function actionMilestoneLoad()
	{
		// change this
		$year = 2018;
		$month = 9;
		$week = 4;

		// insert this
		$startupIds = '2640
		2975
		3163
		3264
		3275
		2166
		1000
		2770
		2772
		3219
		3248
		2729
		3197
		3235
		3242
		3270
		3272
		3144
		3180
		3199
		3549
		84
		2230
		2717
		3249
		2834';

		// insert this
		$values = '$0.00
		$198,000.00
		$187,500.00
		$15,146.00
		$13,000.00
		$15,532.00
		$22,570.00
		$0.00
		$25,000.00
		$4,126.00
		$9,000.00
		$21,886.00
		$3,717.50
		$2,264.00
		$80,475.25
		$233.00
		$265,904.00
		$2,975.00
		$124,000.00
		$20,875.00
		$27,015.40
		$55,122.00
		$8,038.00
		$132,367.00
		$1.50
		$0.00';

		$arrayStartups = (explode("\n", $startupIds));
		$arrayValues = (explode("\n", $values));

		$total = count($arrayStartups);
		for ($i = 0; $i < $total; $i++) {
			$startupId = $arrayStartups[$i];
			$value = str_replace(array(',', '$', ' ', "\t", "\n"), '', $arrayValues[$i]);
			$startup = Organization::model()->findByPk($startupId);
			echo sprintf('<li>#%s %s - %s</li>', $startup->id, $startup->title, $value);
			$sql = sprintf('SELECT * FROM milestone WHERE preset_code="revenue" AND organization_id=%s AND source="atas" LIMIT 0,1', $startupId);

			$milestone = Milestone::model()->findBySql($sql);
			if (empty($milestone)) {
				$milestone = new Milestone;
				$milestone->username = 'afidz@mymagic.my';
				$milestone->organization_id = $startupId;
				$milestone->preset_code = 'revenue';
				$milestone->title = 'Revenue';
				$milestone->is_active = 1;
				$milestone->source = 'atas';
			}
			//{"viewMode":"monthly"}
			$milestone->jsonArray_extra->viewMode = 'monthly';
			$milestone->jsonArray_value[$year][$month][$week]['value'] = trim($value);
			$milestone->jsonArray_value[$year][$month][$week]['realized'] = true;
			$milestone->save(false);
		}
	}

	public function actionSyncFuturelabBookings()
	{
		$programId = 34;
		$tmp = HubFuturelab::syncBookings($programId);
		print_r($tmp);
	}

	public function actionSearchAtBackend()
	{
		/*$model=new Organization('search');
		$model->unsetAttributes();  // clear any default values
		//$model->title = $keyword;
		//$model->searchAccessEmails = array('elbert.chuah');
		//$model->inputBackendTags = array('13');
		//$model->searchBackendTags = array('legend');
		$tmp = $model->search();
		$organizations = $tmp->getData();

		echo '<ol>';
		foreach($organizations as $organization)
		{
			echo sprintf('<li>%s</li>', $organization->title);
		}
		echo '</ol>';*/

		$model = new Individual('search');
		$model->unsetAttributes();  // clear any default values
		//$model->title = $keyword;
		//$model->searchAccessEmails = array('elbert.chuah');
		//$model->inputBackendTags = array('13');
		$model->searchBackendTags = array('legend');
		$tmp = $model->search();
		$individuals = $tmp->getData();

		echo '<ol>';
		foreach ($individuals as $individual) {
			echo sprintf('<li>%s</li>', $individual->full_name);
		}
		echo '</ol>';

		echo '<p>Page Size:</p>';
		print_r($tmp->pagination->getPageSize());

		echo '<p>Item Count:</p>';
		print_r($tmp->pagination->getItemCount());
	}

	public function actionRequestIsSecure()
	{
		echo Yii::app()->getRequest()->isSecureConnection ? 'yes' : 'no';
	}

	public function actionAddress2StateCode($limit = 3000, $offset = 0)
	{
		$individuals = Individual::model()->findAllbySql(sprintf("SELECT * FROM individual WHERE state_code IS NULL AND country_code='MY' LIMIT %s, %s", $offset, $limit));

		foreach ($individuals as $individual) {
			if (!empty($individual->state_code) && !empty($individual->country_code)) {
				continue;
			}

			//$address = '81 Lorong 3A, Taman Pelita Jaya, Jalan Sultan Tengah, 93050 Kuching, Sarawak.';
			// $address = '1600 Pennsylvania Ave., Washington, DC USA';
			$address = $individual->text_address_residential;

			echo '<br />' . $address;
			try {
				$result = HubGeo::address2Geocoder($address);
			} catch (Exception $e) {
				continue;
			}

			if (!empty($result) && !empty($result->first()->getAdminLevels()->first()) && !empty($result->first()->getAdminLevels()->first()->getName())) {
				echo '<br />';
				print_r($result->first()->getLocality());
				echo '<br />';
				print_r($result->first()->getCountryCode());
				echo '<br />';
				print_r($result->first()->getAdminLevels()->first()->getName());
				echo '<br />';
				print_r($result->first()->getAdminLevels()->first()->getCode());

				// try get the state code from db
				$state = State::model()->find('country_code=:country_code AND title=:title', array(':country_code' => $result->first()->getCountryCode(), 'title' => $result->first()->getAdminLevels()->first()->getName()));

				if (isset($state) && !empty($state->code)) {
					$stateCode = $state->code;
				} else {
					continue;

					// insert into state
					$stateCode = sprintf('%s-%s', strtolower($result->first()->getCountryCode()), strtolower($result->first()->getAdminLevels()->first()->getCode()));
					$state = new State;
					$state->code = $stateCode;
					$state->country_code = $result->first()->getCountryCode();
					$state->title = $result->first()->getAdminLevels()->first()->getName();
					$state->save();

					sleep(10);
				}

				//echo '<br />';
				//echo $stateCode;

				$sql = sprintf("UPDATE individual SET state_code='%s', country_code='%s' WHERE id=%s", $stateCode, $result->first()->getCountryCode(), $individual->id);

				//echo $sql.'<br />';exit;
				Yii::app()->db->createCommand($sql)->query();
			}
		}
	}

	public function actionFixAdminsWithoutMember()
	{
		$tmps = Admin::model()->findAll();

		echo '<ol>';
		foreach ($tmps as $admin) {
			echo sprintf('<li>%s - %s</li>', $admin->username, !empty($admin->user->member) ? 'OK' : 'X');

			if (empty($admin->user->member)) {
				$member = new Member;
				$member->user_id = $admin->user->id;
				$member->username = $admin->user->username;
				$member->date_added = $admin->user->date_added;
				$member->date_modified = $admin->user->date_modified;
				$member->save();
			}
		}
		echo '</ol>';
	}

	public function actionOpenDataEventStartup()
	{
		// get all event_organization with event which is active and not is cancelled ordered by oldest event first

		$sql = sprintf("SELECT e.title as eventTitle, eg.title as eventGroupTitle, e.text_short_desc as eventShortDesc, e.url_website as eventUrl, e.date_started as eventDateStarted, e.date_ended as eventDateEnded, e.full_address as eventFullAddress, e.email_contact as eventEmailContact, o.title as orgTitle, o.text_oneliner as orgOneLiner, o.text_short_description as orgShortDesc, o.year_founded as orgYearFounded, c.printable_name as orgCountry, o.url_website as orgUrl,
		(SELECT i.title FROM industry as i RIGHT JOIN industry2organization as i2o ON i.id=i2o.industry_id WHERE i2o.organization_id=o.id ORDER BY i.title ASC LIMIT 0, 1) as orgIndustry1,
		(SELECT i.title FROM industry as i RIGHT JOIN industry2organization as i2o ON i.id=i2o.industry_id WHERE i2o.organization_id=o.id ORDER BY i.title  ASC LIMIT 1, 1) as orgIndustry2,
		(SELECT i.title FROM industry as i RIGHT JOIN industry2organization as i2o ON i.id=i2o.industry_id WHERE i2o.organization_id=o.id ORDER BY i.title  ASC LIMIT 2, 1) as orgIndustry3,
		(SELECT i.title FROM industry as i RIGHT JOIN industry2organization as i2o ON i.id=i2o.industry_id WHERE i2o.organization_id=o.id ORDER BY i.title  ASC LIMIT 3, 1) as orgIndustry4,
		(SELECT i.title FROM industry as i RIGHT JOIN industry2organization as i2o ON i.id=i2o.industry_id WHERE i2o.organization_id=o.id ORDER BY i.title  ASC LIMIT 4, 1) as orgIndustry5
		FROM event_organization as eo
		LEFT JOIN event as e ON e.id=eo.event_id
		LEFT JOIN organization o ON o.id=eo.organization_id
		LEFT JOIN event_group as eg ON eg.code=e.event_group_code
		LEFT JOIN country as c ON c.code=o.address_country_code
		WHERE eo.as_role_code='selectedParticipant' AND e.is_active=1 AND e.is_cancelled!=1 AND o.is_active=1 ORDER BY eg.title ASC, e.date_started ASC, o.title ASC");

		//echo $sql;

		/*
		Program Name
		Program Group
		Program Description
		Program Website URL
		Date Started
		Date Ended
		Program Location
		Contact Email
		Startup Name
		Startup Oneliner
		Startup Description
		Year Founded
		Origin Country
		Startup Website URL
		Industry 1
		Industry 2
		Industry 3
		Industry 4
		Industry 5
		*/

		$headers = array(
			'Program Name',
			'Program Group',
			'Program Description',
			'Program Website URL',
			'Date Started',
			'Date Ended',
			'Program Location',
			'Contact Email',
			'Startup Name',
			'Startup Oneliner',
			'Startup Description',
			'Year Founded',
			'Origin Country',
			'Startup Website URL',
			'Industry 1',
			'Industry 2',
			'Industry 3',
			'Industry 4',
			'Industry 5',
		);

		$buffer[] = $headers;

		$records = Yii::app()->db->createCommand($sql)->queryAll();
		//echo '<pre>';print_r($records);
		foreach ($records as $record) {
			$record['eventDateStarted'] = Html::formatDateTimezone($record['eventDateStarted'], 'standard', 'standard', '-', 'ASIA/Kuala_Lumpur');
			$record['eventDateEnded'] = Html::formatDateTimezone($record['eventDateEnded'], 'standard', 'standard', '-', 'ASIA/Kuala_Lumpur');

			foreach ($record as $rKey => &$rValue) {
				if (trim($rValue) == '') {
					$rValue = '-';
				}
			}
			$buffer[] = $record;
		}

		// echo '<pre>';print_r($buffer);exit;
		$filename = sprintf('%s.%s.csv', 'MaGICEventStartup', date('Ymd'));

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$out = fopen('php://output', 'w');
		foreach ($buffer as $fields) {
			fputcsv($out, $fields);
		}
		fclose($out);
	}

	public function actionSumMilestoneRevenueRealized()
	{
		return HUB::sumMilestoneRevenueRealized();
	}

	public function actionOrganizationSetTag()
	{
		$org = Organization::model()->findByPk(89);
		$org->tag_backend = $org->tag_backend . ', test';
		$org->save();
		print_r($org->tag_backend);
	}

	public function actionRegistry()
	{
		HubRegistry::set('test-abc', 'Hello World');
		print_r(HubRegistry::get('test-abc'));
		HubRegistry::set('test-abc', 'Hello World 123');
		print_r(HubRegistry::get('test-abc'));
	}

	// the value of event is either float or boolean, cannot be string
	public function actionPiwikTracker()
	{
		Yii::import('application.extensions.matomoPhpTracker.PiwikTracker');
		$piwikTracker = new PiwikTracker(1, 'http:' . Yii::app()->params['piwikTrackerUrl']);
		$piwikTracker->setTokenAuth(Yii::app()->params['piwikTokenAuth']);
		$tmp = $piwikTracker->doTrackEvent('theKey', 'testCategory.testAction', 'theValue');
		var_dump($tmp);
	}

	public function actionLinkTest()
	{
		echo Yii::app()->createUrl('/mentor/private/confirmBooking', array(
			'utm_campaign' => 'campaign1',
			'utm_source' => 'fb',
			'utm_medium' => 'web',
		));
	}

	public function actionNotifyMakerInConsole($id)
	{
		$request = Request::model()->findByPk($id);
		$result = array(
			'status' => 'success', 'msg' => '', 'data' => array(
				'path' => "uploads\/userDataPack\/2.1529472310.e8967dad6865a0fde5d64b944e52f22f5a0723bb.html", 'url' => "https:\/\/mymagic-hub.s3.amazonaws.com\/uploads\/userDataPack\/2.1529472310.e8967dad6865a0fde5d64b944e52f22f5a0723bb.html")
		);
		$notifyMaker = NotifyMaker::member_user_dataDownloadRequestDone($request, $result);
		print_r($notifyMaker);
	}

	public function actionMailchimpGetOne()
	{
		$listId = Yii::app()->params['mailchimpLists']['magicNewsletter'];
		$result = HubMailchimp::getOneMailchimpList(HubMailchimp::getAllMailchimpList(), $listId);
		print_r($result);
	}

	public function actionMailchimpSubscribe()
	{
		$email = 'exiang83@gmail.com';
		//$listId = '0776188580';
		$listId = Yii::app()->params['mailchimpLists']['magicNewsletter'];

		$result = HubMailchimp::subscribeMailchimpList($email, $listId, ['firstname' => 'Allen', 'lastname' => 'Tan']);
		var_dump($result);
	}

	public function actionMailchimpUnsubscribe()
	{
		$email = 'exiang83@gmail.com';
		//$listId = '0776188580';
		$listId = Yii::app()->params['mailchimpLists']['magicNewsletter'];

		$result = HubMailchimp::unsubscribeMailchimpList($email, $listId);
		print_r($result);
	}

	public function actionMailchimpView()
	{
		$email = 'exiang83@gmail.com';
		//$listId = '0776188580';
		$listId = Yii::app()->params['mailchimpLists']['magicNewsletter'];

		$result = HubMailchimp::isEmailExistsMailchimpList($email, $listId);
		print_r($result);
	}

	public function actionMailchimp()
	{
		$result = HubMailchimp::getAllMailchimpList(100);
		foreach ($result['lists'] as $list) {
			echo sprintf('<li>%s - %s</li>', $list['name'], $list['id']);
		}
		echo '<pre>';
		print_r($result);
	}

	public function actionCreateUserDataDownload()
	{
		//$username = 'exiang83@gmail.com';
		$username = 'yee.siang@mymagic.my';
		//$format = 'html';
		$format = 'json';

		$user = HUB::getUserByUsername($username);
		$tmp = HUB::createUserDataDownload($user, $format);
		echo '<pre>';
		print_r($tmp);
	}

	public function actionProcessUserDataDownloadRequest($id)
	{
		print_r(HUB::processUserDataDownloadRequest($id));
	}

	public function actionExtractLanguageTag()
	{
		echo Yii::t('test', 'Testing 123');
		echo Yii::t('test', 'Testing 456');

		//$content = "echo Yii::t('test', \"Testing {var}\", array('{var}'=>123));";
		$content = file_get_contents(Yii::getPathOfAlias('views') . DIRECTORY_SEPARATOR . 'test/languageTag.php');

		preg_match_all('/Yii::t\(([^\$]+?)\'\)/', $content, $pregLanguageKey, PREG_PATTERN_ORDER);

		print_r($pregLanguageKey);
	}

	public function actionConvertCurrency()
	{
		$tmp = HUB::convertCurrency(100, 'MYR', 'SGD', '2018-06-06');
		print_r($tmp);
	}

	public function actionRecordCurrencyExchangeRates()
	{
		$tmp = HUB::recordCurrencyExchangeRates('2018-05-25');
		print_r($tmp);
	}

	public function actionGetCurrencyExchangeRatesHistoricalData()
	{
		$tmp = HUB::getCurrencyExchangeRatesHistoricalData('2018-05-23', '2018-06-02');
		print_r($tmp);
	}

	public function actionGetOpenExchangeRatesHistoricalApi()
	{
		$date = '2018-05-01';
		$body = HUB::getCurrencyExchangeRatesData($date);
		print_r($body);
	}

	// not working, need subscription plan
	public function actionGetOpenExchangeRatesTimeSeriesApi()
	{
		$url = sprintf('https://openexchangerates.org/api/time-series.json?app_id=%s', Yii::app()->params['openExchangeRatesAppId']);

		$client = new \GuzzleHttp\Client();

		$response = $client->request(
			'GET',

			$url,
			['headers' => [
					'Accept' => 'application/json',
					'Content-Type' => 'application/json'
				],
			'form_params' => [
				'start' => '2018-05-01',
				'end' => '2018-05-30'
			]
			]
		);
		$body = (string)$response->getBody();
		echo $body;
	}

	public function actionGetOpenExchangeRatesApi()
	{
		$url = sprintf('https://openexchangerates.org/api/latest.json?app_id=%s', Yii::app()->params['openExchangeRatesAppId']);

		$client = new \GuzzleHttp\Client();

		$response = $client->request(
			'GET',

			$url,
			['headers' => [
					'Accept' => 'application/json',
					'Content-Type' => 'application/json'
				],
			'form_params' => []
			]
		);
		$body = (string)$response->getBody();
		echo $body;
	}

	public function actionTextPhpExcel()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="testPhpExcel.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function actionMilestoneUpdateValues()
	{
		$milestone = Milestone::model()->findByPk(1);
		$milestone->jsonArray_value['2018']['1'][1]['value'] = '201801.10';
		$milestone->jsonArray_value['2018']['2'][1] = array('realized' => false, 'value' => '201802.01');
		$milestone->save();
	}

	public function actionMilestoneGetValues()
	{
		$milestone = Milestone::model()->findByPk(1);
		print_r($milestone->jsonArray_value);
	}

	public function actionMilestoneSaveValues()
	{
		$milestone = new Milestone;
		$milestone->title = 'Test Milestone';
		$milestone->username = 'exiang83@gmail.com';
		$milestone->preset_code = 'revenue';
		$milestone->jsonArray_value['2017']['1'][4] = array('realized' => false, 'value' => '201701');
		$milestone->jsonArray_value['2017']['2'][4] = array('realized' => false, 'value' => '201702');
		$milestone->jsonArray_value['2017']['3'][4] = array('realized' => false, 'value' => '201703');
		$milestone->jsonArray_value['2017']['4'][4] = array('realized' => false, 'value' => '201704');
		$milestone->jsonArray_value['2017']['5'][4] = array('realized' => false, 'value' => '201705');

		$milestone->jsonArray_value['2018']['1'][1] = array('realized' => true, 'value' => '201801.01');
		$milestone->jsonArray_value['2018']['1'][2] = array('realized' => true, 'value' => '201801.02');
		$milestone->jsonArray_value['2018']['1'][3] = array('realized' => false, 'value' => '201801.03');
		$milestone->jsonArray_value['2018']['1'][4] = array('realized' => false, 'value' => '201801.04');

		$milestone->save();
	}

	public function actionIdeaEnterpriseMembershipUpgraded()
	{
		$enterprises = HubIdea::getUserEnterprises('exiang83@gmail.com');
		$enterprise = $enterprises[0];
		$return = NotifyMaker::organization_idea_enterpriseMembershipUpgraded($enterprise);
		print_r($return);
	}

	public function actionGetOrganizations()
	{
		$bufferFilter = "persona.slug='startups' AND o.title LIKE 'emanyan%'";
		$offset = 0;
		$limitPerPage = 100;
		$sql = sprintf('SELECT o.* FROM organization as `o`
			LEFT JOIN persona2organization as `p2o` ON p2o.organization_id=o.id
			LEFT JOIN persona as persona ON p2o.persona_id=persona.id

			LEFT JOIN industry2organization as `i2o` ON i2o.organization_id=o.id
			LEFT JOIN industry as industry ON i2o.industry_id=industry.id

			LEFT JOIN event_organization as eo ON eo.organization_id=o.id

			WHERE %s GROUP BY o.id ORDER BY o.title ASC LIMIT %s, %s ', $bufferFilter, $offset, $limitPerPage);

		//echo $sql;exit;
		$items = Organization::model()->findAllBySql($sql);

		foreach ($items as $item) {
			print_r($item->toApi());
		}
	}

	public function actionSearchOrganizationByIndustry()
	{
		$criteria = new CDbCriteria;
		$criteria->together = true;
		// 1: agriculture
		$inputIndustries = array('1');

		if ($inputIndustries !== null) {
			$criteriaIndustry = new CDbCriteria;
			$criteriaIndustry->together = true;
			$criteriaIndustry->with = array('industries');
			foreach ($inputIndustries as $industry) {
				$criteriaIndustry->addCondition(sprintf('industries.id=%s', trim($industry)), 'OR');
			}
			$criteria->mergeWith($criteriaIndustry, 'AND');
		}

		$result = new CActiveDataProvider('Organization', array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 30),
			'sort' => array(
				'defaultOrder' => 't.title ASC',
			),
		));

		$organizations = $result->getData();
		foreach ($organizations as $organization) {
			echo sprintf('<li>%s</li>', $organization->title);
		}
	}

	public function actionFuturelabBookingStatusException()
	{
		Yii::import('application.modules.mentor.models.*');
		$meta = null;
		try {
			$booking = new Booking;
			$b = HubFuturelab::getBooking(1500);
			$booking->loadFrom($b);

			print_r($booking);
		} catch (GuzzleHttp\Exception\ClientException $e) {
			$jsonArray = json_decode($e->getResponse()->getBody()->getContents());
			$this->outputFail($jsonArray->error, $meta);
		} catch (Exception $e) {
			echo $e->getMessage();
			//echo $e->getMessage();
		}
	}

	public function actionTimezone2Offset()
	{
		$timezone = 'America/Los_Angeles';
		$tz = timezone_open($timezone);
		$dtGMT = date_create('now', timezone_open('GMT'));
		echo timezone_offset_get($tz, $dtGMT) / 3600;
	}

	public function actionResourceMany2ManyIssue()
	{
		$many2many = Resource2Industry::model()->findAll();
		//$many2many = Resource2Industry::model()->findByAttributes(array('resource_id'=>2674, 'industry_id'=>16));
		//$many2many = Role2User::model()->findByAttributes(array('role_id'=>1, 'user_id'=>2));
		print_r($many2many);
	}

	public function actionMigrateOrganization()
	{
		// merge from source into target organization
		$keywordSource = 'magic';
		$keywordTarget = 'MaGIC (Malaysian Global Innovation & Creativity Centre)';

		$source = Organization::model()->findByAttributes(array('title' => $keywordSource));
		$target = Organization::model()->findByAttributes(array('title' => $keywordTarget));
		$result = HUB::doOrganizationsMerge($source, $target);
		var_dump($result);
	}

	public function actionViewOrganizationNodes($keyword)
	{
		if (is_numeric($keyword)) {
			$org = Organization::model()->findByAttributes(array('id' => $keyword));
		} else {
			$org = Organization::model()->findByAttributes(array('title' => $keyword));
		}

		echo sprintf('<h3>#%s - %s -%s</h3>', $org->id, $org->title, $org->code);
		echo '<h4>Meta</h4>';
		foreach ($org->_dynamicData as $dt => $dd) {
			echo sprintf('<li>%s: %s</li>', $dt, $dd);
		}

		echo '<h4>Charge</h4>';
		foreach ($org->charges as $charge) {
			echo sprintf('<li>#%s %s</li>', $charge->id, $charge->title);
		}

		echo '<h4>organization2Emails</h4>';
		foreach ($org->organization2Emails as $organization2Email) {
			echo sprintf('<li>#%s %s [%s]</li>', $organization2Email->id, $organization2Email->user_email, $organization2Email->status);
		}

		echo '<h4>eventOrganizations</h4>';
		foreach ($org->eventOrganizations as $eventOrganization) {
			echo sprintf('<li>#%s event:%s from vendor:%s as role:%s</li>', $eventOrganization->id, $eventOrganization->event->title, $eventOrganization->event_vendor_code, $eventOrganization->as_role_code);
		}

		// todo: class not found yet
		/*echo '<h4>eventOwners</h4>';
		foreach($org->eventOwners as $eventOwner)
		{
			echo sprintf('<li>#%s event:%s department:%s</li>', $eventOwner->id, $eventOwner->event_code, $eventOwner->department);
		}*/

		echo '<h4>My ideaRfps</h4>';
		foreach ($org->ideaRfps as $ideaRfp) {
			echo sprintf('<li>#%s %s [%s]</li>', $ideaRfp->id, $ideaRfp->title, $ideaRfp->status);
		}

		echo '<h4>ideaRfp2Enterprise to Me</h4>';
		$tmps = $org->getIdeaSentRfps2Enterprise();
		foreach ($tmps as $ideaRfp2Enterprise) {
			//print_r($ideaRfp2Enterprise);exit;
			echo sprintf('<li>#%s %s</li>', $ideaRfp2Enterprise->id, $ideaRfp2Enterprise->title);
		}

		// todo: skip for now as it is not implemented yet
		/*echo '<h4>idea Wishlist</h4>';*/

		echo '<h4>impact2Organization</h4>';
		foreach ($org->impacts as $impact) {
			echo sprintf('<li>#%s %s</li>', $impact->id, $impact->title);
		}

		echo '<h4>industry2Organization</h4>';
		foreach ($org->industries as $industry) {
			echo sprintf('<li>#%s %s</li>', $industry->id, $industry->title);
		}

		echo '<h4>Sent notify</h4>';
		foreach ($org->sentNotifies as $notify) {
			echo sprintf('<li>%s</li>', $notify->message);
		}
		echo '<h4>Received notify</h4>';
		foreach ($org->receivedNotifies as $notify) {
			echo sprintf('<li>%s</li>', $notify->message);
		}

		echo '<h4>organizationFundings</h4>';
		$sql = sprintf('SELECT * FROM organization_funding WHERE organization_id=%s', $org->id);
		$tmps = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($tmps as $tmp) {
			echo sprintf('<li>#%s raised $%s from %s</li>', $tmp['id'], $tmp['amount'], $tmp['vc_name']);
		}

		echo '<h4>organizationRevenues</h4>';
		$sql = sprintf('SELECT * FROM organization_revenue WHERE organization_id=%s', $org->id);
		$tmps = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($tmps as $tmp) {
			echo sprintf('<li>#%s reported $%s on year %s</li>', $tmp['id'], $tmp['amount'], $tmp['year_reported']);
		}

		echo '<h4>organizationStatus</h4>';
		$sql = sprintf('SELECT * FROM organization_status WHERE organization_id=%s', $org->id);
		$tmps = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($tmps as $tmp) {
			echo sprintf('<li>#%s is %s according to %s</li>', $tmp['id'], $tmp['status'], $tmp['source']);
		}

		echo '<h4>persona2Organization</h4>';
		foreach ($org->personas as $persona) {
			echo sprintf('<li>#%s %s</li>', $persona->id, $persona->title);
		}

		echo '<h4>products</h4>';
		foreach ($org->products as $product) {
			echo sprintf('<li>#%s %s</li>', $product->id, $product->title);
		}

		echo '<h4>resource2organization</h4>';
		foreach ($org->resources as $resource) {
			echo sprintf('<li>#%s %s</li>', $resource->id, $resource->title);
		}

		// todo: class not found yet
		/*echo '<h4>vacancies</h4>';*/
	}

	public function actionAddEventOrganization()
	{
		$org = Organization::model()->findByAttributes(array('title' => 'emanyan'));
		$event = Event::model()->findByAttributes(array('title' => 'test'));
		//print_r($event);
		$org->addEventOrganization($event->code, 'test', array('eventVendorCode' => 'test', 'registrationCode' => 'x12345'));
		$org->save();
		echo '<pre>';
		print_r($org);
	}

	public function actionCountEventOrganizationRole()
	{
		$sql = sprintf('SELECT COUNT(id) as total, (as_role_code) FROM `event_organization` WHERE event_id=%s GROUP BY as_role_code', 11194);
		$tmp = Yii::app()->db->createCommand($sql)->queryAll();
		print_r($tmp);
	}

	public function actionCreateIndividual()
	{
		$email = 'exiang83@yahoo.com';
		$fullname = 'Tan Yee Siang';

		if (Individual::isFullnameExists($fullname)) {
			$idv = Individual::fullname2obj($fullname);
		} else {
			$idv = new Individual;
			$idv->full_name = 'Tan Yee Siang';
			$idv->gender = 'male';
			$idv->country_code = 'MY';
			$idv->text_address_residential = '126, Jln Warisan Indah 8/16, Kota Warisan 43900 Selangor';
			$idv->can_code = 1;
			$idv->save();
		}
		//var_dump($idv->getErrors());

		// add email to individual
		if (!$idv->hasUserEmail($email)) {
			$i2e = new Individual2Email;
			$i2e->individual_id = $idv->id;
			$i2e->user_email = $email;
			$i2e->is_verify = 1;
			$i2e->save();
		}

		// add persona to individual
		$personaStartup = Persona::slug2obj('startups');
		$idv->addPersona($personaStartup->id);
	}

	public function actionRemotePhotoFileUpload()
	{
		$urlImage = 'https://atasbe.mymagic.my/uploads/map_participant/photo.893.jpg?secret=magic123';
		$ruf = new RemoteUploadedFile;
		$ruf->setUrl($urlImage);
		var_dump($ruf);

		$fullname = 'LEONARD FOO ZHUANG KEAT';
		$idv = Individual::fullname2obj($fullname);
		$idv->imageRemote_photo = $ruf;
		$idv->save();
		RemoteUploadManager::storeImage($idv, 'photo', $idv->tableName());

		echo sprintf('<p>%s</p><p>Thumbnail: <img src="%s"></p><p>Fullsize: <img src="%s"></p>', $idv->getImagePhotoUrl(), $idv->getImagePhotoThumbUrl(), $idv->getImagePhotoUrl());
	}

	public function actionRemoteLogoFileUpload()
	{
		$urlImage = 'http://atasbe.mymagic.my/uploads/startup/logo.590150.png?secret=magic123';
		//$urlImage = 'http://atasbe.mymagic.my/uploads/startup/logo.827729.png?secret=magic123';
		$ruf = new RemoteUploadedFile;
		$ruf->setUrl($urlImage);
		var_dump($ruf);

		$title = 'whenso';
		$org = Organization::title2obj($title);
		$org->imageRemote_logo = $ruf;
		$org->save();
		RemoteUploadManager::storeImage($org, 'logo', $org->tableName());

		echo sprintf('<p>%s</p><p>Thumbnail: <img src="%s"></p><p>Fullsize: <img src="%s"></p>', $org->getImageLogoUrl(), $org->getImageLogoThumbUrl(), $org->getImageLogoUrl());
	}

	public function actionGetOrganization()
	{
		$title = 'BluBear';
		Yii::app()->db->setActive(true);

		$org = Organization::title2obj($title);

		echo $title;
		var_dump($org);
	}

	public function actionLayoutBackend()
	{
		$this->layout = 'backend';
		$this->render('index');
	}

	public function actionCheckYeebase()
	{
		echo $this->checkYeebase();
	}

	public function actionYiiPdf()
	{
		$mpdf = Yii::app()->ePdf->mpdf();
		$mpdf->WriteHTML('<p>Hello</p>');
		$mpdf->Output();
		exit;
	}

	public function actionMpdf()
	{
		$mpdf = new \Mpdf\Mpdf(array('tempDir' => Yii::getPathOfAlias('application.runtime')));
		//echo $mpdf->tempDir;exit;
		$mpdf->WriteHTML('<p>Hello</p>');
		$mpdf->Output();
		exit;
	}

	public function actionMentorSlots($programId)
	{
		$mentors = HubFuturelab::getProgramMentors($programId);
		$result['monday'] = null;
		$result['tuesday'] = null;
		$result['wednesday'] = null;
		$result['thursday'] = null;
		$result['friday'] = null;
		$result['saturday'] = null;
		$result['sunday'] = null;
		//print_r($mentors);exit;
		foreach ($mentors as $mentor) {
			foreach ($mentor->timeslots as $timeslot) {
				if ($timeslot->program_id != $programId) {
					continue;
				}

				foreach ($timeslot->days as $weekday => $times) {
					foreach ($times as $time) {
						$result[$weekday][$time][] = sprintf('%s %s', $mentor->firstname, $mentor->lastname);
					}
				}
			}
		}

		$this->layout = 'frontend';
		$this->render('mentorSlots', array('result' => $result));
	}

	public function actionMagicMentorBooking($dateStart, $dateEnd)
	{
		$timestampStart = strtotime($dateStart);
		$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

		echo sprintf('<h2>From %s to %s</h2>', date('Y-m-d H:i T', $timestampStart), date('Y-m-d H:i T', $timestampEnd));

		$totalBookings = 0;
		$totalRejects = 0;
		$totalCancels = 0;
		$totalArchiveds = 0;
		$totalPendings = 0;
		$totalHistories = 0;
		echo sprintf('<h4>%s</h4>', 'MaGIC Mentorship');
		echo '<ol>';

		$bookings = HubFuturelab::getProgramBookings(34);
		usort($bookings, 'HubFuturelab::cmpBooking');
		$bookings = array_reverse($bookings);

		foreach ($bookings as $b) {
			$timestampBooking = strtotime($b->booking_time);
			if ($timestampBooking >= $timestampStart && $timestampBooking < $timestampEnd) {
				if ($b->status == 'upcoming' || $b->status == 'history' || $b->status == 'archived') {
					//print_r($b);exit;
					$booking = new Booking;
					$booking->loadFrom($b);

					echo sprintf('<li>#%s %s %s (%s) mentoring %s %s (%s) on %s thru %s</li>', $booking->id, $booking->mentor->firstname, $booking->mentor->lastname, $booking->mentor->email, $booking->mentee->firstname, $booking->mentee->lastname, $booking->mentee->email, date('D, Y-m-d H:i T', strtotime($b->booking_time)), $b->session_method);
				} elseif ($b->status == 'rejected') {
					$totalRejects++;
				} elseif ($b->status == 'cancelled') {
					$totalCancels++;
				} elseif ($b->status == 'archived') {
					$totalArchiveds++;
				} elseif ($b->status == 'pending') {
					$totalPendings++;
				} elseif ($b->status == 'history') {
					$totalHistories++;
				}
				$totalBookings++;
			}
		}
		echo '</ol>';
		echo sprintf('<p><b>%s of total bookings including pending, upcoming, history, rejected, cancelled, archived</b></p>', $totalBookings);
		echo sprintf('<p>Rejected: %s, Cancelled: %s, Pending: %s, History: %s, Archived: %s</p>', $totalRejects, $totalCancels, $totalPendings, $totalHistories, $totalArchiveds);
	}

	public function actionGodView($dateStart, $dateEnd)
	{
		Yii::import('application.modules.mentor.models.*');

		$enable['events'] = true;
		$enable['mentorships'] = true;
		$enable['organizationEmails'] = true;
		$enable['resources'] = true;
		$enable['users'] = true;

		// only for user who can access backend
		if (!Yii::app()->user->accessBackend) {
			echo 'This page only available to admin with backend access';
		} else {
			$timestampStart = strtotime($dateStart);
			$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

			echo sprintf('<h2>From %s to %s</h2>', date('Y-m-d H:i T', $timestampStart), date('Y-m-d H:i T', $timestampEnd));

			// date range can not be more than 60 days
			if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
				echo '<p>Max date range cannot more than 60 days!</p>';
				Yii::app()->end();
			}

			//echo '<h3>Connect</h3>';

			if ($enable['events']) {
				echo '<hr />';

				echo '<h3>Events</h3>';
				echo '<ol>';
				$sql = sprintf('SELECT * FROM event WHERE is_active=1 AND is_cancelled!=1 AND date_started>=%s AND date_started<%s ORDER BY date_started DESC', $timestampStart, $timestampEnd);
				$startEvents = Event::model()->findAllBySql($sql);
				foreach ($startEvents as $e) {
					echo sprintf("<li><b>'%s'</b> started on %s at %s</li>", $e->title, date('D, Y-m-d H:i T', $e->date_started), $e->at);
				}
				echo '</ol>';
			}

			if ($enable['mentorships']) {
				echo '<hr />';

				$mentorPrograms = HubFuturelab::getPrograms();

				echo '<h3>Mentorships (Session Date)</h3>';
				foreach ($mentorPrograms as $mp) {
					$totalBookings = 0;
					$totalRejects = 0;
					$totalCancels = 0;
					$totalArchiveds = 0;
					$totalPendings = 0;
					$totalHistories = 0;
					$totalUpcomings = 0;
					$totalMagics = 0;

					echo sprintf('<h4>%s</h4>', $mp->name);
					echo '<ol>';

					$bookings = HubFuturelab::getProgramBookings($mp->id);
					usort($bookings, 'HubFuturelab::cmpBooking');
					$bookings = array_reverse($bookings);

					foreach ($bookings as $b) {
						$timestampBooking = strtotime($b->booking_time);
						if ($timestampBooking >= $timestampStart && $timestampBooking < $timestampEnd) {
							if ($b->status == 'upcoming' || $b->status == 'history' || $b->status == 'archived') {
								$booking = new Booking;
								$booking->loadFrom($b);
								$isMagic = strstr($booking->mentor->email, '@mymagic.my') && strstr($booking->mentee->email, '@mymagic.my');

								if ($isMagic) {
									echo sprintf('<li><s>#%s %s %s (%s) mentoring %s %s (%s) on %s thru %s</s></li>', $booking->id, $booking->mentor->firstname, $booking->mentor->lastname, $booking->mentor->email, $booking->mentee->firstname, $booking->mentee->lastname, $booking->mentee->email, date('D, Y-m-d H:i T', strtotime($b->booking_time)), $b->session_method);

									$totalMagics++;
								} else {
									echo sprintf('<li>#%s %s %s (%s) mentoring %s %s (%s) on %s thru %s</li>', $booking->id, $booking->mentor->firstname, $booking->mentor->lastname, $booking->mentor->email, $booking->mentee->firstname, $booking->mentee->lastname, $booking->mentee->email, date('D, Y-m-d H:i T', strtotime($b->booking_time)), $b->session_method);
								}
							}

							if ($b->status == 'rejected') {
								$totalRejects++;
							} elseif ($b->status == 'cancelled') {
								$totalCancels++;
							} elseif ($b->status == 'archived') {
								$totalArchiveds++;
							} elseif ($b->status == 'pending') {
								$totalPendings++;
							} elseif ($b->status == 'history') {
								$totalHistories++;
							} elseif ($b->status == 'upcoming') {
								$totalUpcomings++;
							}
							$totalBookings++;
						}
					}
					echo '</ol>';
					echo sprintf('<p><b>%s of total bookings including pending, upcoming, history, rejected, cancelled, archived</b></p>', $totalBookings);
					echo sprintf('<p>Upcoming: %s, Rejected: %s, Cancelled: %s, Pending: %s, History: %s, Archived: %s | Magician: %s | Chargable (upcoming + history - magician - duplicate): %s</p>', $totalUpcomings, $totalRejects, $totalCancels, $totalPendings, $totalHistories, $totalArchiveds, $totalMagics, $totalUpcomings + $totalHistories - $totalMagics);
				}

				echo '<hr />';

				echo '<h3>Mentorships (Created Date)</h3>';
				foreach ($mentorPrograms as $mp) {
					$totalBookings = 0;
					$totalRejects = 0;
					$totalCancels = 0;
					$totalArchiveds = 0;
					$totalPendings = 0;
					$totalHistories = 0;
					$totalUpcomings = 0;
					$totalMagics = 0;

					echo sprintf('<h4>%s</h4>', $mp->name);
					echo '<ol>';

					$bookings = HubFuturelab::getProgramBookings($mp->id);
					usort($bookings, 'HubFuturelab::cmpCreating');
					$bookings = array_reverse($bookings);

					foreach ($bookings as $b) {
						$timestampCreating = strtotime($b->created_at);
						if ($timestampCreating >= $timestampStart && $timestampCreating < $timestampEnd) {
							if ($b->status == 'upcoming' || $b->status == 'history' || $b->status == 'archived') {
								$booking = new Booking;
								$booking->loadFrom($b);
								$isMagic = strstr($booking->mentor->email, '@mymagic.my') && strstr($booking->mentee->email, '@mymagic.my');

								if ($isMagic) {
									echo sprintf('<li><s>#%s %s %s (%s) mentoring %s %s (%s) on %s thru %s, created at %s</s></li>', $booking->id, $booking->mentor->firstname, $booking->mentor->lastname, $booking->mentor->email, $booking->mentee->firstname, $booking->mentee->lastname, $booking->mentee->email, date('D, Y-m-d H:i T', strtotime($b->booking_time)), $b->session_method, date('D, Y-m-d H:i T', strtotime($b->created_at)));

									$totalMagics++;
								} else {
									echo sprintf('<li>#%s %s %s (%s) mentoring %s %s (%s) on %s thru %s, created at %s</li>', $booking->id, $booking->mentor->firstname, $booking->mentor->lastname, $booking->mentor->email, $booking->mentee->firstname, $booking->mentee->lastname, $booking->mentee->email, date('D, Y-m-d H:i T', strtotime($b->booking_time)), $b->session_method, date('D, Y-m-d H:i T', strtotime($b->created_at)));
								}
							}

							if ($b->status == 'rejected') {
								$totalRejects++;
							} elseif ($b->status == 'cancelled') {
								$totalCancels++;
							} elseif ($b->status == 'archived') {
								$totalArchiveds++;
							} elseif ($b->status == 'pending') {
								$totalPendings++;
							} elseif ($b->status == 'history') {
								$totalHistories++;
							} elseif ($b->status == 'upcoming') {
								$totalUpcomings++;
							}
							$totalBookings++;
						}
					}
					echo '</ol>';
					echo sprintf('<p><b>%s of total bookings including pending, upcoming, history, rejected, cancelled, archived</b></p>', $totalBookings);
					echo sprintf('<p>Upcoming: %s, Rejected: %s, Cancelled: %s, Pending: %s, History: %s, Archived: %s | Magician: %s | Chargable (upcoming + history - magician): %s</p>', $totalUpcomings, $totalRejects, $totalCancels, $totalPendings, $totalHistories, $totalArchiveds, $totalMagics, $totalUpcomings + $totalHistories - $totalMagics);
				}
			}

			echo '<hr />';

			echo '<h3>Companies</h3>';
			echo '<h4>New/Update</h4>';
			$sql = sprintf('SELECT * FROM organization WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC', $timestampStart, $timestampEnd);
			$organizations = Organization::model()->findAllBySql($sql);
			if (!empty($organizations)) {
				echo '<ol>';
				foreach ($organizations as $o) {
					echo sprintf("<li><b>'%s'</b> %s on %s</li>", $o->title, $o->date_added == $o->date_modified ? 'added' : 'modified', date('D, Y-m-d H:i T', $o->date_added));
				}
				echo '</ol>';
			} else {
				echo '<p>No new organization added/modified in this period of time</p>';
			}

			if ($enable['organizationEmails']) {
				echo '<hr />';

				echo '<h3>Organization-Email Request</h3>';
				$sql = sprintf('SELECT * FROM organization2email WHERE (date_added>=%s AND date_added<%s) OR (date_modified>=%s AND date_modified<%s) ORDER BY date_modified DESC', $timestampStart, $timestampEnd, $timestampStart, $timestampEnd);
				$emails = Organization2Email::model()->findAllBySql($sql);
				if (!empty($emails)) {
					echo '<ol>';
					foreach ($emails as $e) {
						echo sprintf("<li><b>'%s'</b> request to join <b>'%s'</b> is now %s on %s </li>", $e->user_email, $e->organization->title, ucwords($e->status), date('D, Y-m-d H:i T', $e->date_modified));
					}
					echo '</ol>';
				} else {
					echo '<p>No organization-email request changes found in this period of time</p>';
				}
			}

			if ($enable['resources']) {
				echo '<hr />';

				echo '<h3>Resources</h3>';
				echo '<ol>';
				$sql = sprintf('SELECT * FROM resource WHERE is_active=1 AND date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC', $timestampStart, $timestampEnd);
				$resources = Resource::model()->findAllBySql($sql);
				foreach ($resources as $r) {
					echo sprintf("<li>#%s - <b>'%s'</b> of <b>'%s'</b> %s on %s</li>", $r->id, $r->title, $r->renderTypeFor(), $r->date_modified == $r->date_added ? 'added' : 'modified', date('D, Y-m-d H:i T', $r->date_modified));
				}
				echo '</ol>';
			}

			if ($enable['users']) {
				echo '<hr />';

				echo '<h3>Users</h3>';
				echo '<ol>';
				$sql = sprintf('SELECT * FROM user WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC', $timestampStart, $timestampEnd);
				$users = User::model()->findAllBySql($sql);
				if (!empty($users)) {
					echo '<ol>';
					foreach ($users as $u) {
						echo sprintf("<li><b>'%s '</b> joined on %s</li>", $u->username, date('D, Y-m-d H:i T', $u->date_added));
					}
					echo '</ol>';
				} else {
					echo '<p>No new user joined in this period of time</p>';
				}
				echo '</ol>';
			}
		}
	}

	public function actionFuturelabCreateBookingEmail($id, $programId)
	{
		Yii::import('application.modules.mentor.models.*');
		$booking = new Booking;
		$tmp = HubFuturelab::getBooking($id, $programId);
		$booking->loadFrom($tmp);
		//echo $booking->renderContactInfo();exit;
		//print_r($booking);exit;
		$customParams['urlManage'] = sprintf('https://www.futurelab.my/users/%s/bookings?filter=none', $booking->mentor_id);
		$customParams['companyName'] = 'Minda Cerdas';
		$customParams['enquiry'] = 'How can I raise funding?';

		$notifMaker = NotifyMaker::mentor_mentor_createFuturelabBooking($booking, $customParams);

		//echo $notifMaker['content'];exit;

		// sendEmail($email, $name, $title, $content, $options)
		HUB::sendEmail($booking->mentor->email, sprintf('%s %s', $booking->mentor->firstname, $booking->mentor->lastname), $notifMaker['title'], $notifMaker['content']);
	}

	public function actionIdeaInsight()
	{
		$impacts = Impact::model()->findAllByAttributes(array('is_active' => 1));
		foreach ($impacts as $impact) {
			echo sprintf('<h2>%s</h2>', $impact->title);
			// get all active organization of this impact
			$sql = sprintf('SELECT o.* FROM impact as i LEFT JOIN impact2organization as i2o ON i2o.impact_id=i.id LEFT JOIN organization as o ON i2o.organization_id=o.id WHERE i.id=%s AND o.is_active=1', $impact->id);
			$organizations = Organization::model()->findAllBySql($sql);
			echo '<ol>';
			foreach ($organizations as $organization) {
				echo sprintf('<li><h4>%s</h4>', $organization->title);
				// get all rfps
				$sql2 = sprintf('SELECT r.* FROM idea_rfp as r LEFT JOIN idea_rfp2enterprise as r2e ON r2e.idea_rfp_id=r.id LEFT JOIN organization as o ON o.code=r2e.enterprise_organization_code WHERE o.id=%s', $organization->id);
				$rfps = IdeaRfp::model()->findAllBySql($sql2);
				echo '<ol>';
				foreach ($rfps as $rfp) {
					echo sprintf('<li>%s</li>', $rfp->title);
				}
				echo '</ol>';
				echo '</li>';
			}
			echo '</ol>';
		}
	}

	// to test the ordering and selection mode
	public function actionGetFuturelabMenteePrivateBookings()
	{
		$bookings = HubFuturelab::getMenteePrivateBookings(2343, 'cancelled');
		foreach ($bookings as $booking) {
			echo sprintf('<li>[%s] %s Meeting %s %s thru %s</li>', $booking->status, $booking->booking_time, $booking->mentor->firstname, $booking->mentor->lastname, $booking->session_method);
		}
	}

	public function actionUseCache()
	{
		echo Yii::app()->params['cache'] ? 'true' : 'false';
	}

	public function actionIsFuturelabMentorBelongs2Program()
	{
		$mentorId = 1745;
		$programId = 32;
		print_r(HubFuturelab::isMentorBelongs2Program($mentorId, $programId));
	}

	public function actionMakeBooking()
	{
		$params['programId'] = 32;
		$params['mentorId'] = 1745;
		$params['menteeEmail'] = 'yeesiang83@gmail.com';
		$params['menteeFirstname'] = 'Yee siang';
		$params['menteeLastname'] = 'Tan';
		$params['sessionMethod'] = 'meetup';
		$params['date'] = '2017-11-27';
		$params['time'] = '11:00';
		$params['timezone'] = '+08:00';

		try {
			$result = HubFuturelab::createBooking($params);
		} catch (GuzzleHttp\Exception\ClientException $e) {
			$jsonArray = json_decode($e->getResponse()->getBody()->getContents());
			echo $jsonArray->error;
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		print_r($result);
	}

	public function actionMakeBookingRaw()
	{
		/*{
		"booking": {
			"id": 47,
			"mentor_id": 1,
			"mentee_id": 2,
			"status": "\"pending\", \"upcoming\", \"history\", \"rejected\", \"cancelled\", \"archived\"\n",
			"booking_time": "2017-06-22T07:00:00.000Z",
			"program_id": 5,
			"session_method": "\"hangouts\", \"meetup\", \"whatsapp\", \"skype\"\n",
			"length": "30"
		},
		"mentee": {
			"firstname": "Joey",
			"lastname": "Chan",
			"email": "joey@futurelab.my"
		}
		}*/

		$payload = array(
			'booking' => array(
				'mentor_id' => 1745, 'status' => 'pending', 'booking_time' => '2017-12-27T11:00:00.000+08:00', 'program_id' => 32, 'session_method' => 'meetup', 'length' => 30
			),
			'mentee' => array(
				'firstname' => 'Yee Siang', 'lastname' => 'Tan', 'email' => 'yeesiang83@gmail.com'
			)
		);

		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->getModule('mentor')->futurelabApiBaseUrl]);

		$response = $client->request(
			'POST',

			sprintf('bookings'),
		['headers' => [
				'client-secret' => Yii::app()->getModule('mentor')->futurelabApiSecret,
				'Accept' => 'application/json',
				'Content-Type' => 'application/json'
			],
		'json' => $payload,
		'form_params' => []
		]
		);
		$body = (string)$response->getBody();
		$return = json_decode($body);
		print_r($return);
	}

	public function actionAcuityScheduling()
	{
		$this->render('acuityScheduling');
	}

	public function actionGetUserOrganizationsCanJoin()
	{
		$tmps = HUB::getUserOrganizationsCanJoin('ma', 'exiang83@gmail.com');
		print_r($tmps);
	}

	public function actionJwt()
	{
		echo base64_encode(openssl_random_pseudo_bytes(64));
	}

	public function actionCenterThumb()
	{
		//$this->layout = '/layout/bank';
		$this->render('centerThumb');
	}

	public function actionTestThumbGenerate()
	{
		$url = 'http://hubd.mymagic.my/sys/thumb/generate/table/resource/field/logo/size/32x32/specific/dXBsb2Fkcy9yZXNvdXJjZS9sb2dvLjUxLnBuZw%3D%3D/forceGenerate/1/render/0';
		$client = new GuzzleHttp\Client();
		$response = $client->get($url);
		echo($response->getBody());
	}

	public function actionLtrimString()
	{
		$string = 'Hello World';
		// left trim, remove 'Hell'
		echo substr($string, strlen('Hell'));
		echo '<br>';
		// right trim, remove 'rld'
		echo substr($string, 0, -1 * strlen('rld'));
	}

	public function actionCrudResource()
	{
		$r = new Resource;
		$r->title = 'Test 123';
		$r->slug = 'test-123';
		$r->html_content = 'lalala';
		echo $r->save();
		print_r($r->getErrors());

		// get it
		$r = Resource::model()->findByAttributes(array('slug' => 'test-123'));
		echo $r->title;
		$r->inputPersonas = array('1dfbd855-ae5c-4fcf-8282-7fff19049244');
	}

	public function actionCamel2Words()
	{
		preg_match_all('/((?:^|[A-Z])[a-z]+)/', 'resourceCategories', $matches);
		echo implode(' ', $matches[0]);
	}

	public function actionResourceInit()
	{
		$r = new Resource;
		echo $r->uploadPath;
	}

	public function actionActivateCorpJoin()
	{
		$client = new \GuzzleHttp\Client();
		try {
			$res = $client->post('http://api.magicactivate.com/v1/corporate-join/', array('json' => array(
				'first_name' => 'Allen',
				'last_name' => 'Tan',
				'company_name' => 'Test Corp 1',
				'email' => 'exiang83@yahoo.com',
				'contact_no' => '0126130617',
				'looking_for' => 'headache 2',
			)));

			echo $res->getStatusCode();
			print_r(json_decode($res->getBody()));
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
	}

	public function actionDuplicateFlash()
	{
		Notice::flash('hello world (only 1 of these should show)');
		Notice::flash('hello world (only 1 of these should show)');
		//Notice::flash("Hello World");
		$this->render('index');
	}

	public function actionCreateJunk()
	{
		$junk = new Junk;
		$junk->code = 'test-' . time();
		$junk->content = 'Hello world from ' . Yii::app()->params['masterDomain'];
		$junk->save();
	}

	public function actionEsLogComponent()
	{
		echo Yii::app()->esLog->esTestVar;
		Yii::app()->esLog->esTestVar = 'abc';
		echo Yii::app()->esLog->esTestVar;
	}

	public function actionEsLogDelete($context, $id)
	{
		$params = [
			'index' => Yii::app()->params['esLogIndexCode'],
			'type' => $context,
			'id' => $id
		];

		$response = Yii::app()->esLog->getClient()->delete($params);

		print_r($response);
	}

	public function actionEsLogMentorCustom()
	{
		$username = 'exiang83@yahoo.com';

		$log = Yii::app()->esLog(
			sprintf("updated booking with mentor '%s %s' (%s) #%s", 'Foo', 'Bar', 'foobar@mymagic.my', '9999'),
			'mentor',
			array('trigger' => 'HubFuturelab::createBooking', 'model' => '', 'action' => '', 'id' => 9999),
			$username,
			array('programId' => 88)
		);
	}

	// test the custom field
	public function actionEsLogExtra()
	{
		$username = 'exiang83@yahoo.com';

		$this->esLog('[test] test extra with empty data', 'test', array('hello' => 'world', 'diff1' => '1'), $username);

		$this->esLog('[test] test extra with variant 2', 'test', array('hello' => 'world', 'diff2' => '2'), $username, array('diff2' => '2'));

		$this->esLog('[test] test extra with variant 3', 'test', array('hello' => 'world', 'diff3' => '3'), $username, array('diff3' => '3'));

		$this->esLog('[test1] test extra with variant 4', 'test1', array('hello' => 'world', 'diff4' => '4'), $username, array('diff4' => '4'));

		$this->esLog('[test1] test extra with variant 5', 'test1', array('hello' => 'world', 'diff5' => '5'), $username, array('diff5' => '5'));
	}

	public function actionEsLogByOrganization($limit = '100')
	{
		echo sprintf('<h2>Latest %s organization log from %s</h2>', $limit, Yii::app()->params['esLogIndexCode']);

		$params = [
			'index' => Yii::app()->params['esLogIndexCode'],
			'size' => $limit,
			'body' => [
				'query' => [
					'match' => [
						'organizationId' => '3584'
					]
				],
				'sort' => [
					'dateLog' => ['order' => 'desc']
				]
			]
		];
		$response = Yii::app()->esLog->getClient()->search($params);
		foreach ($response['hits']['hits'] as $r) {
			$rCustom = json_decode($r['_source']['customJson'], true);

			$urlParams['id'] = $r['_source']['id'];
			$action = 'view';
			$controller = $r['_source']['model'];
			if ($controller == 'user') {
				$controller = 'member';
			}
			if ($r['_type'] == 'mentor') {
				$controller = 'mentor/program';
				$action = 'viewBooking';
				$urlParams['programId'] = $rCustom['programId'];
			}

			echo sprintf(
				'<li>%s - [%s] %s %s <a href="%s" target="_blank">Go</a> | <a href="%s" target="_blank">Delete</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>%s</small></li>',
			date('Y-M-d H:i:s', $r['_source']['dateLog']),
				$r['_type'],
				$r['_source']['username'],
				$r['_source']['msg'],
				$this->createUrl($controller . '/' . $action, $urlParams),
				$this->createUrl('test/esLogDelete', array('context' => $r['_type'], 'id' => $r['_id'])),
				$r['_source']['customJson']
			);
		}
	}

	public function actionEsLogLatest($limit = '100')
	{
		echo sprintf('<h2>Latest %s log from %s</h2>', $limit, Yii::app()->params['esLogIndexCode']);

		$params = [
			'index' => Yii::app()->params['esLogIndexCode'],
			'size' => $limit,
			'body' => [
				'sort' => [
					'dateLog' => ['order' => 'desc']
				]
			]
		];
		$response = Yii::app()->esLog->getClient()->search($params);
		foreach ($response['hits']['hits'] as $r) {
			$rCustom = json_decode($r['_source']['customJson'], true);

			$urlParams['id'] = $r['_source']['id'];
			$action = 'view';
			$controller = $r['_source']['model'];
			if ($controller == 'user') {
				$controller = 'member';
			}
			if ($r['_type'] == 'mentor') {
				$controller = 'mentor/program';
				$action = 'viewBooking';
				$urlParams['programId'] = $rCustom['programId'];
			}

			echo sprintf(
				'<li>%s - [%s] %s %s <a href="%s" target="_blank">Go</a> | <a href="%s" target="_blank">Delete</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>%s</small></li>',
			date('Y-M-d H:i:s', $r['_source']['dateLog']),
				$r['_type'],
				$r['_source']['username'],
				$r['_source']['msg'],
				$this->createUrl($controller . '/' . $action, $urlParams),
				$this->createUrl('test/esLogDelete', array('context' => $r['_type'], 'id' => $r['_id'])),
				$r['_source']['customJson']
			);
		}
	}

	public function actionEsLogClearAllJunk()
	{
		$params = ['index' => Yii::app()->params['esLogIndexCode'], 'type' => 'junk'];
		$response = Yii::app()->esLog->getClient()->search($params);

		foreach ($response['hits']['hits'] as $r) {
			$params['body'][] = array(
				'delete' => array(
					'_index' => Yii::app()->params['esLogIndexCode'],
					'_type' => $r['_type'],
					'_id' => $r['_id']
				)
			);
		}
		//print_r($params);exit;
		$response = Yii::app()->esLog->getClient()->bulk($params);
		print_r($response);
	}

	public function actionEsLogAddJunk()
	{
		$msg = "Yee Siang added junk 'Avenger Begins'";

		$junk = new Junk;
		$junk->code = 'test-esLogAddJunk-' . time();
		$junk->content = $msg;
		$junk->save();

		$context = 'junk';
		$data['model'] = 'junk';
		$data['action'] = 'create';
		$data['id'] = $junk->id;
		$username = 'yee.siang@mymagic.my';
		$extra['user']['full_name'] = 'Yee Siang';

		$response = $this->esLog($msg, $context, $data, $username, $extra);
		print_r($response);
	}

	public function actionEsLogListJunk()
	{
		$params = [
			'type' => 'junk',
			'body' => [
				/*'query' => [
					'match' => [
						//'challengeId' => '99'
					]
				],*/
				'sort' => [
					'dateLog' => ['order' => 'desc']
				]
			]
		];

		$response = Yii::app()->esLog->getClient()->search($params);
		//

		foreach ($response['hits']['hits'] as $r) {
			echo sprintf('<li>#%s: %s on %s (%s)<a href="%s">View</a></li>', $r['_id'], $r['_source']['msg'], date('r', $r['_source']['dateLog']), $r['_source']['extra']['user']['full_name'], $this->createUrl('/junk/view', array('id' => $r['_source']['id'])));
		}

		echo '<pre>';
		print_r($response);
	}

	public function actionEsLogClearAll()
	{
		$params = [
			'index' => 'test-log',
		];

		$response = Yii::app()->esLog->getClient()->search($params);

		foreach ($response['hits']['hits'] as $r) {
			$params['body'][] = array(
				'delete' => array(
					'_index' => 'test-log',
					'_type' => $r['_type'],
					'_id' => $r['_id']
				)
			);
			//$this->esLog->delete($params)
		}
		//print_r($params);exit;
		$response = Yii::app()->esLog->getClient()->bulk($params);
		print_r($response);
	}

	public function actionEsLogListAll()
	{
		$params = [
			'index' => Yii::app()->params['esLogIndexCode'],
		];

		$response = Yii::app()->esLog->getClient()->search($params);

		foreach ($response['hits']['hits'] as $r) {
			echo sprintf('<li>#%s: %s %s</li>', $r['_id'], $r['_source']['msg'], date('Y M d', $r['_source']['dateLog']));
		}
	}

	public function actionEsLogController()
	{
		$params = [
			'index' => 'test-log',
			//'type' => 'challenge',
			'body' => [
				'query' => [
					'match' => [
						'challengeId' => '99'
					]
				],
				'sort' => [
					'dateAction' => ['order' => 'desc']
				]
			]
		];

		$response = Yii::app()->esLog->getClient()->search($params);
		//

		foreach ($response['hits']['hits'] as $r) {
			echo sprintf('<li>#%s: %s %s</li>', $r['_id'], $r['_source']['msg'], date('Y M d', $r['_source']['dateAction']));
		}

		echo '<pre>';
		print_r($response);
	}

	public function actionEsLogList()
	{
		$endpoint = 'https://search-esearch-zx63o5rpb4egkcrluaepveku74.ap-southeast-1.es.amazonaws.com:443';

		$provider = CredentialProvider::fromCredentials(
			new Credentials(Yii::app()->params['esLogKey'], Yii::app()->params['esLogSecret'])
		);

		$handler = new ElasticsearchPhpHandler('ap-southeast-1', $provider);

		// Use this handler to create an Elasticsearch-PHP client
		$client = ClientBuilder::create()
			->setHandler($handler)
			->setHosts([$endpoint])
			->build();

		// https://github.com/elastic/elasticsearch-php
		// by username
		$params = [
			'index' => 'test-log',
			//'type' => 'challenge',
			'body' => [
				'query' => [
					'match' => [
						'username' => 'exiang83@yahoo.com'
						//'challengeId' => '99'
					]
				],
				'sort' => [
					'dateAction' => ['order' => 'desc']
				]
			]
		];
		// by challengeId
		$params = [
			'index' => 'test-log',
			//'type' => 'challenge',
			'body' => [
				'query' => [
					'match' => [
						'challengeId' => '99'
					]
				],
				'sort' => [
					'dateAction' => ['order' => 'desc']
				]
			]
		];

		$response = $client->search($params);
		//

		foreach ($response['hits']['hits'] as $r) {
			echo sprintf('<li>%s %s</li>', $r['_source']['msg'], date('Y M d', $r['_source']['dateAction']));
		}

		echo '<pre>';
		print_r($response);
	}

	public function actionEsLogAdd()
	{
		$endpoint = 'https://search-esearch-zx63o5rpb4egkcrluaepveku74.ap-southeast-1.es.amazonaws.com:443';

		$provider = CredentialProvider::fromCredentials(
			new Credentials(Yii::app()->params['esLogKey'], Yii::app()->params['esLogSecret'])
		);

		$handler = new ElasticsearchPhpHandler('ap-southeast-1', $provider);

		// Use this handler to create an Elasticsearch-PHP client
		$client = ClientBuilder::create()
			->setHandler($handler)
			->setHosts([$endpoint])
			->build();

		// https://github.com/elastic/elasticsearch-php
		$params = [
			'index' => 'test-log',
			'type' => 'application',
			'body' => [
				'username' => 'yee.siang@mymagic.my',
				'fullname' => 'Tan Yee Siang',
				'action' => 'update',
				'msg' => 'Tan Yee Siang updated application #10',
				'applicationId' => 10,
				'challengeId' => 99,
				'dateAction' => time()
			]
		];

		$response = $client->index($params);
		print_r($response);
	}

	public function actionEsMapType()
	{
		$endpoint = 'https://search-esearch-zx63o5rpb4egkcrluaepveku74.ap-southeast-1.es.amazonaws.com:443';

		$provider = CredentialProvider::fromCredentials(
			new Credentials(Yii::app()->params['esLogKey'], Yii::app()->params['esLogSecret'])
		);

		$handler = new ElasticsearchPhpHandler('ap-southeast-1', $provider);

		// Use this handler to create an Elasticsearch-PHP client
		$client = ClientBuilder::create()
			->setHandler($handler)
			->setHosts([$endpoint])
			->build();

		$params = ['index' => 'test-pasar'];
		$response = $client->indices()->getMapping();
		var_dump($response);
	}

	public function actionEsSearch()
	{
		$endpoint = 'https://search-esearch-zx63o5rpb4egkcrluaepveku74.ap-southeast-1.es.amazonaws.com:443';

		$provider = CredentialProvider::fromCredentials(
			new Credentials(Yii::app()->params['esLogKey'], Yii::app()->params['esLogSecret'])
		);

		$handler = new ElasticsearchPhpHandler('ap-southeast-1', $provider);

		// Use this handler to create an Elasticsearch-PHP client
		$client = ClientBuilder::create()
			->setHandler($handler)
			->setHosts([$endpoint])
			->build();

		// https://github.com/elastic/elasticsearch-php
		$params = [
			'index' => 'test-pasar',
			'type' => 'order',
			'body' => [
				'query' => [
					'match' => [
						'items.name' => 'manggo'
					]
				]
			]
		];

		$response = $client->search($params);
		print_r($response);
	}

	public function actionEsAdd()
	{
		$endpoint = 'https://search-esearch-zx63o5rpb4egkcrluaepveku74.ap-southeast-1.es.amazonaws.com:443';

		$provider = CredentialProvider::fromCredentials(
			new Credentials(Yii::app()->params['esLogKey'], Yii::app()->params['esLogSecret'])
		);

		$handler = new ElasticsearchPhpHandler('ap-southeast-1', $provider);

		// Use this handler to create an Elasticsearch-PHP client
		$client = ClientBuilder::create()
			->setHandler($handler)
			->setHosts([$endpoint])
			->build();

		$response = $client->indices()->delete([
			'index' => 'test-pasar'
		]);
		//print_r($response);

		$params = [
			'index' => 'test-pasar',
			'type' => 'order',
			'id' => '1',
			'body' => ['total' => 100, 'date' => '20170717', 'items' => array(
					array('name' => 'durian', 'unit' => 1, 'total' => 80),
					array('name' => 'manggo', 'unit' => 1, 'total' => 20),
				)
			]
		];
		$response = $client->index($params);

		$params = [
			'index' => 'test-pasar',
			'type' => 'order',
			'id' => '2',
			'body' => ['total' => 250, 'date' => '20170715', 'items' => array(
					array('name' => 'watermelon', 'unit' => 10, 'total' => 100),
					array('name' => 'manggo', 'unit' => 5, 'total' => 100),
					array('name' => 'ciku', 'unit' => 10, 'total' => 50),
				)
			]
		];
		$response = $client->index($params);

		//
	}

	public function actionLazyLoadIdeaEnterprise()
	{
		$tmps = (HubIdea::getAllActiveEnterprises(6, 3));
		foreach ($tmps as $tmp) {
			echo sprintf('%s<br />', $tmp->title);
		}
	}

	public function actionUserAvatar()
	{
		//echo $this->remoteAvatar;
		//echo $this->user->profile->image_avatar;
		//$this->user->profile->image_avatar = 'abc';
		//echo $this->user->profile->image_avatar;
		echo Html::activeThumb($this->user->profile, 'image_avatar');
	}

	public function actionMagicUserData()
	{
		$data = $this->magicConnect->getUserData('exiang83@gmail.com');
		print_r($data);
		echo $this->magicConnect->getConnectUrl() . '/' . $data->avatar;
	}

	public function actionResetYs()
	{
		$sql = sprintf("DELETE FROM organization2email WHERE user_email='yeesiang83@gmail.com'");
		Yii::app()->db->createCommand($sql)->execute();
		echo 'sql executed: ' . $sql;
	}

	public function actionResendRfp()
	{
		echo Yii::app()->getModule('idea')->emailTeam;

		$rfp = IdeaRfp::model()->findByPk(36);
		HubIdea::sendRfp($rfp, true);
		echo '<pre>';
		print_r($rfp);
	}

	public function actionConnect()
	{
		/*$userdata =  $this->magicConnect->connect($_GET['code'], Yii::app()->params['connectClientId'], Yii::app()->params['connectSecretKey'],
			   $this->createAbsoluteUrl('site/connectCallback'));
		*/

		echo $this->magicConnect->getConnectUrl();
		//echo $this->magicConnect->setToken('');
		// echo $this->magicConnect->getconnectUrl();exit;
		$result = $this->magicConnect->isUserExists('exiang83@gmail.com');
		echo($result == true ? 'Yes' : 'No');
	}

	public function actionSendRfpEmailPreview()
	{
		$rfp = IdeaRfp::model()->findByPk(10);
		$return = NotifyMaker::organization_idea_createRfp($rfp, $rfp->partner);
		echo '<pre>';
		print_r($return);
		echo '<hr/><hr />';
		$return = NotifyMaker::organization_idea_sendRfp($rfp, $rfp->enterprises[0], $rfp->partner);
		echo '<pre>';
		print_r($return);
	}

	public function actionGetOrganization2Emails()
	{
		$tmps = (HUB::getOrganization2Emails(3));
		foreach ($tmps['model'] as $tmp) {
			echo sprintf('%s - %s<br>', $tmp->id, $tmp->user_email);
		}
	}

	public function actionGenUUID()
	{
		echo ysUtil::generateUUID();
	}

	public function actionGetProductMeta()
	{
		$product = Product::model()->findByPk(1);
		//echo $product->title;
		print_r($product->_dynamicFields);
		print_r($product->_dynamicData['Product-idea-isHighlight']);

		// the following will not works
		$var = 'Product-idea-isHighlight';
		print_r($product->$var);
	}

	public function actionGetAllEnrolledOrganizationsInIdea()
	{
		// get all organization with meta value of Organization-idea-isEnrolled=1
		$orgs = Organization::model()->with('metaStructures', 'metaItems')->findAll(
			array('condition' => "
				(metaStructures.code='Organization-idea-isEnrolled' AND metaItems.value=1 ANd metaItems.ref_id=t.id)
			")
		);
		foreach ($orgs as $org) {
			echo $org->title . '<br>';
		}
	}

	public function actionGetAllHighlightedProductsInIdea()
	{
		// 'organization.metaStructures'=>array('alias'=>'orgMetaStructures'), 'organization.metaItems'=>array('alias'=>'orgMetaItems')

		// get all product with meta value of Product-idea-isHighlight=1
		$products = Product::model()->with(array('organization', 'metaStructures', 'metaItems', ))->findAll(
			array('condition' => "
				(metaStructures.code='Product-idea-isHighlight' AND metaItems.value=1 AND metaItems.ref_id=t.id)
			")
		);
		foreach ($products as $product) {
			echo $product->title . '<br>';
		}
	}

	public function actionMetaItem()
	{
		$metaStruct = MetaStructure::model()->findByPk(3);
		echo MetaItem::insertOrUpdate($metaStruct, 1, 'Hello');
	}

	public function actionViewTx()
	{
		$tx = Transaction::model()->findByPk(4);
		echo $tx->jsonArray_payload->first_name;

		/*
		need to manually decode. this will give u:
		Array
		(
			[refType] => charge
			[refId] => test-147620951
		)*/
		print_r(json_decode($tx->jsonArray_payload->custom, true));

		print_r($tx);
	}

	public function actionCreateTx()
	{
		$tx = new Transaction;
		$tx->vendor = 'test';
		$tx->txnid = '12345';
		$tx->txntype = 'web_accept';
		$tx->txntype_code = '';
		$tx->amount = '0.99';
		$tx->ref_id = '1';
		$tx->ref_type = 'charge';
		$tx->status = 'Completed';
		$tx->is_valid = 1;
		$tx->save();
	}

	public function actionPaypalPay()
	{
		$this->render('paypalPay');
	}

	public function actionPaypalPDT()
	{
		echo '<pre>';
		print_r($_GET);

		$keyarray = HUB::processPaypalPDT($_GET['tx']);
		if (!empty($keyarray)) {
			$firstname = $keyarray['first_name'];
			$lastname = $keyarray['last_name'];
			$itemname = $keyarray['item_name'];
			$amount = $keyarray['payment_gross'];

			echo('<p><h3>Thank you for your purchase!</h3></p>');

			echo("<b>Payment Details</b><br>\n");
			echo("<li>Name: $firstname $lastname</li>\n");
			echo("<li>Item: $itemname</li>\n");
			echo("<li>Amount: $amount</li>\n");
			echo('');
			print_r($keyarray);

			$result = HUB::insertOrUpdateTransaction('paypal', $keyarray['txn_id'], $keyarray['txn_type'], json_encode($keyarray), '');
			print_r($result);
		} else {
			echo 'Invalid key array. unable to retrieve PDT processed data';
		}
	}

	public function actionPaypalPayIPN()
	{
		$this->render('paypalPayIPN');
	}

	public function actionPaypalIPN()
	{
		echo 'Page Exists';

		$junk = new Junk;
		$junk->code = 'test-paypalIPN-' . time();
		$junk->content = sprintf('called on: %s', Yii::app()->params['masterDomain']);
		$junk->save();

		$listener = new IpnListener();

		// default options
		$listener->use_sandbox = true;
		$listener->use_curl = true;
		$listener->follow_location = false;
		$listener->timeout = 30;
		$listener->verify_ssl = true;

		try {
			if ($verified = $listener->processIpn()) {
				// handle successful ipn request
				// 1. Check that $_POST['payment_status'] is "Completed"
				if ($_POST['payment_status'] != 'Completed') {
					throw new Exception('Payment not completed');
				}
				// 2. Check that $_POST['receiver_email'] is your Primary PayPal email
				if ($_POST['receiver_email'] != Yii::app()->params['paypalBusiness']) {
					throw new Exception('Payment receiver email not matched');
				}
				// 3. Check that $_POST['txn_id'] has not been previously processed
				// 4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] are correct

				// ok
				$junk = new Junk;
				$junk->code = 'test-paypalIPN-' . time();
				$junk->content = 'ok:' . json_encode($_POST);
				$junk->save();
			}
		} catch (Exception $e) {
			// handle invalid ipn request
			$junk = new Junk;
			$junk->code = 'test-paypalIPN-' . time();
			$junk->content = 'not ok:' . json_encode($_POST);
			$junk->save();
		}
	}

	public function actionUpdates($dateStart, $dateEnd)
	{
		Yii::import('application.modules.mentor.models.*');

		// only for user who can access backend
		if (!Yii::app()->user->accessBackend) {
			echo 'This page only available to admin with backend access';
		} else {
			$timestampStart = strtotime($dateStart);
			$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

			if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
				echo '<p>Max date range cannot more than 60 days!</p>';
				Yii::app()->end();
			}

			//echo '<h3>Connect</h3>';

			$sql = sprintf('SELECT * FROM event WHERE is_active=1 AND is_cancelled!=1 AND date_started>=%s AND date_started<%s ORDER BY date_started DESC', $timestampStart, $timestampEnd);
			$startEvents = Event::model()->findAllBySql($sql);

			$sql = sprintf('SELECT * FROM organization WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC', $timestampStart, $timestampEnd);
			$organizations = Organization::model()->findAllBySql($sql);

			$sql = sprintf('SELECT * FROM organization2email WHERE (date_added>=%s AND date_added<%s) OR (date_modified>=%s AND date_modified<%s) ORDER BY date_modified DESC', $timestampStart, $timestampEnd, $timestampStart, $timestampEnd);
			$emails = Organization2Email::model()->findAllBySql($sql);

			$sql = sprintf('SELECT * FROM resource WHERE is_active=1 AND date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC', $timestampStart, $timestampEnd);
			$resources = Resource::model()->findAllBySql($sql);

			$sql = sprintf('SELECT * FROM user WHERE is_active=1 AND date_added>=%s AND date_added<%s ORDER BY date_added DESC', $timestampStart, $timestampEnd);
			$users = User::model()->findAllBySql($sql);
		}

		$this->render('updates', array('timestampStart' => $timestampStart, 'timestampEnd' => $timestampEnd, 'startEvents' => $startEvents, 'organizations' => $organizations, 'emails' => $emails, 'resources' => $resources, 'users' => $users
		));
	}

	public function actionExploreProd($keyword = 'plants')
	{
		$products = HubIdea::searchProducts($keyword);

		print_r($products);
		// print_r($products);
	}

	public function actionGetUsedImpacts()
	{
		$impacts = HubIdea::getAllUsedImpact2Organization();

		foreach ($impacts as $i) {
			echo 'impact title : ' . $i->title . '. impact id: ' . $i->id . '<br>';
		}
	}

	public function actionGetOrganizationByImpactId($id)
	{
		$org = HubIdea::getOrganizationByImpactId($id);

		foreach ($org as $o) {
			echo 'org title : ' . $o->title . '<br>';
		}
	}

	public function actionSeolytic()
	{
		$this->render('seolytic');
	}

	public function actionPregMatchPath()
	{
		$pattern = '/test\/seolytic/';
		//$urlPath = Yii::app()->request->url;
		$urlPath = 'test/seolytic';
		$matches = array();
		preg_match($pattern, $urlPath, $matches);
		print_r($matches);
		echo sprintf('%s vs %s', $pattern, $urlPath);
	}
}
