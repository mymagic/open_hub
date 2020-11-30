<?php

class CvPortfolio extends CvPortfolioBase
{
	public $url_website;
	public $url_linkedin;
	public $url_twitter;
	public $url_facebook;
	public $url_github;
	public $url_stackoverflow;

	public $urlImageRemote_avatar;
	public $imageRemote_avatar;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		$this->image_avatar = $this->getDefaultImageAvatar();
		// custom code here
		// ...

		parent::init();

		// return void
	}

	public function beforeValidate()
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate()
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...
		if (empty($this->slug)) {
			// generateRandomKey($max=5, $min=4, $mode='alphanumeric')
			$this->slug = YsUtil::generateRandomKey(8, 5, 'alphanumeric');

			while ($this->isSlugExists($this->slug)) {
				$this->slug = YsUtil::generateRandomKey(8, 5, 'alphanumeric');
			}
		}

		// json
		$this->jsonArray_social->url_website = $this->url_website;
		$this->jsonArray_social->url_linkedin = $this->url_linkedin;
		$this->jsonArray_social->url_twitter = $this->url_twitter;
		$this->jsonArray_social->url_facebook = $this->url_facebook;
		$this->jsonArray_social->url_github = $this->url_github;
		$this->jsonArray_social->url_stackoverflow = $this->url_stackoverflow;

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...

		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		if (empty($this->image_avatar)) {
			$this->image_avatar = $this->getDefaultImageAvatar();
		}

		// custom code here
		// ...
		$this->jsonArray_social = json_decode($this->json_social);
		$this->url_website = $this->jsonArray_social->url_website;
		$this->url_linkedin = $this->jsonArray_social->url_linkedin;
		$this->url_twitter = $this->jsonArray_social->url_twitter;
		$this->url_facebook = $this->jsonArray_social->url_facebook;
		$this->url_github = $this->jsonArray_social->url_github;
		$this->url_stackoverflow = $this->jsonArray_social->url_stackoverflow;

		parent::afterFind();

		// return void
	}

	public function getDefaultImageAvatar()
	{
		return 'uploads/cv_portfolio/avatar.default.jpg';
	}

	public function isDefaultImageAvatar()
	{
		if ($this->image_avatar == $this->getDefaultImageAvatar()) {
			return true;
		}

		return false;
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slug', 'unique', 'allowEmpty' => true, 'className' => 'CvPortfolio', 'attributeName' => 'slug', 'caseSensitive' => false, 'message' => 'Slug must be an unique alpha numerical value only. Email is not allowed'),
			array('slug', 'length', 'max' => 24),
			array('slug', 'CRegularExpressionValidator', 'pattern' => '/^([0-9a-z-_]+)$/', 'message' => 'Invalid slug format. Please insert alpha numerical value only. Email is not allowed'),
			array('url_website, url_linkedin, url_twitter, url_facebook, url_github, url_stackoverflow', 'url'),

			array('user_id, display_name', 'required'),
			array('user_id, cv_jobpos_id, high_academy_experience_id, current_job_experience_id, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('organization_name, location, display_name, image_avatar', 'length', 'max' => 255),
			array('state_code', 'length', 'max' => 12),
			array('country_code', 'length', 'max' => 2),
			array('text_oneliner', 'length', 'max' => 200),
			array('visibility', 'length', 'max' => 9),
			array('text_address_residential, latlong_address_residential, text_short_description', 'safe'),
			array('imageFile_avatar', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('urlImageRemote_avatar', 'url'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, slug, cv_jobpos_id, organization_name, location, text_address_residential, latlong_address_residential, state_code, country_code, display_name, image_avatar, high_academy_experience_id, current_job_experience_id, text_oneliner, text_short_description, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, visibility, is_active, json_social, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified, url_website, url_linkedin, url_twitter, url_facebook, url_github, url_stackoverflow', 'safe', 'on' => 'search'),
			// meta
			array('_dynamicData', 'safe'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cvExperiences' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id'),
			'cvExperiencesSorted' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id', 'order' => 'year_start DESC, month_start DESC'),
			'activeCvExperiences' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id', 'condition' => 'is_active=1'),
			'activeCvExperiencesSorted' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id', 'order' => 'year_start DESC, month_start DESC', 'condition' => 'is_active=1'),
			'activeStudyCvExperiences' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id', 'condition' => 'is_active=1 AND genre="study"'),

			'country' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'highAcademyExperience' => array(self::BELONGS_TO, 'CvExperience', 'high_academy_experience_id'),
			'currentJobExperience' => array(self::BELONGS_TO, 'CvExperience', 'current_job_experience_id'),
			'cvJobpos' => array(self::BELONGS_TO, 'CvJobpos', 'cv_jobpos_id', 'order' => 'cvJobpos.title ASC'),
			'state' => array(self::BELONGS_TO, 'State', 'state_code'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
	}

	public function attributeLabels()
	{
		return array(
		'id' => Yii::t('app', 'ID'),
		'user_id' => Yii::t('app', 'User'),
		'slug' => Yii::t('app', 'Slug'),
		'cv_jobpos_id' => Yii::t('app', 'I am'),
		'location' => Yii::t('app', 'Location'),
		'state_code' => Yii::t('app', 'State'),
		'country_code' => Yii::t('app', 'Country'),
		'display_name' => Yii::t('app', 'Display Name'),
		'image_avatar' => Yii::t('app', 'Avatar'),
		'text_short_description' => Yii::t('app', 'Short Description'),
		'text_address_residential' => Yii::t('app', 'Current Address'),
		'latlong_address_residential' => Yii::t('app', 'Current Address Location'),
		'text_oneliner' => Yii::t('app', 'Oneliner'),
		'high_academy_experience_id' => Yii::t('app', 'Highest Academy'),
		'current_job_experience_id' => Yii::t('app', 'Current Job'),
		'is_looking_fulltime' => Yii::t('app', 'Fulltime'),
		'is_looking_contract' => Yii::t('app', 'Contract'),
		'is_looking_freelance' => Yii::t('app', 'Freelance'),
		'is_looking_internship' => Yii::t('app', 'Internship'),
		'is_looking_apprenticeship' => Yii::t('app', 'Apprenticeship'),
		'is_looking_cofounder' => Yii::t('app', 'Co-Founder'),
		'json_social' => Yii::t('app', 'Social Links'),
		'json_extra' => Yii::t('app', 'Extra'),
		'is_active' => Yii::t('app', 'Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
	}

	public function resetAddressParts()
	{
		if (!empty($this->text_address_residential)) {
			$addressParts = HubGeo::geocoder2AddressParts(HubGeo::address2Geocoder($this->text_address_residential));
			/*$this->address_line1 = $addressParts['line1'];
			$this->address_line2 = $addressParts['line2'];
			$this->address_zip = $addressParts['zipcode'];*/
			if (!empty($addressParts['city'])) {
				$this->location = $addressParts['city'];
			}
			if (!empty($addressParts['countryCode'])) {
				$this->country_code = $addressParts['countryCode'];
			}
			if (!empty($addressParts['state'])) {
				$state = State::findByTitle($addressParts['state'], $this->country_code);
				if (!empty($state)) {
					$this->state_code = $state->code;
				}
			}
			$this->setLatLongAddressResidential(array($addressParts['lat'], $addressParts['lng']));
		}
	}

	public function getAttendedPrograms()
	{
		$sql = sprintf('SELECT e.*, YEAR(FROM_UNIXTIME(date_started)) AS year_start, MONTH(FROM_UNIXTIME(date_started)) AS month_start, YEAR(FROM_UNIXTIME(date_ended)) AS year_end, MONTH(FROM_UNIXTIME(date_ended)) AS month_end FROM 
		`event` as e LEFT JOIN `event_registration` as er ON e.id=er.event_id LEFT JOIN user2email as u2e ON er.email=u2e.user_email, cv_portfolio as f LEFT JOIN user as u ON f.user_id=u.id 
		WHERE e.is_active=1 AND e.is_cancelled=0 AND 
		er.is_attended=1 AND  (er.email=u.username OR (u2e.is_verify=1 AND er.email=u2e.user_email)) AND u.username=:username
		GROUP BY e.id ORDER BY e.date_started DESC');

		return Yii::app()->db->createCommand($sql)->bindParam(':username', $this->user->username, PDO::PARAM_STR)->queryAll();
	}

	public function gaugeComposedExperiences()
	{
		$sql = 'SELECT COUNT(*) FROM (
			(SELECT e.id 
			FROM `event_registration` AS er 
			LEFT JOIN `event` as e ON e.id=er.event_id
			WHERE er.is_attended=1 AND e.is_active=1 AND e.is_cancelled=0 AND er.email IN (SELECT u2e.user_email as email FROM user AS u LEFT JOIN user2email as u2e On u2e.user_id=u.id AND u2e.is_verify=1 WHERE u.username=:username UNION SELECT :username as email)
			GROUP BY e.id)

			UNION ALL
		
			(SELECT e.id AS id 
			FROM `cv_experience` as e 
			LEFT JOIN cv_portfolio as f ON f.id=e.cv_portfolio_id 
			LEFT JOIN user as u ON f.user_id=u.id 
			WHERE e.is_active=1 AND u.username=:username
			GROUP BY e.id
			)
		) results';

		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':username', $this->user->username, PDO::PARAM_STR);

		return $command->queryScalar();
	}

	public function getComposedExperiences($page = 1, $limit = 30)
	{
		$sql = "SELECT * FROM (
			(SELECT 'event' AS genre, e.id AS id, e.title AS title, '' as organization_name, er.email as email, e.at AS location, e.address_country_code AS countryCode, e.address_state_code AS stateCode, '' AS description, '1' AS isEndorsed, 'fa-star text-warning' AS faIcon,
			e.date_started AS dateStarted,
			YEAR(FROM_UNIXTIME(date_started)) AS yearStart, MONTH(FROM_UNIXTIME(date_started)) AS monthStart, MONTHNAME(FROM_UNIXTIME(date_started)) AS monthNameStart,
			YEAR(FROM_UNIXTIME(date_ended)) AS yearEnd, MONTH(FROM_UNIXTIME(date_ended)) AS monthEnd 
			FROM `event_registration` AS er 
			LEFT JOIN `event` as e ON e.id=er.event_id
			WHERE er.is_attended=1 AND e.is_active=1 AND e.is_cancelled=0 AND er.email IN (SELECT u2e.user_email as email FROM user AS u LEFT JOIN user2email as u2e On u2e.user_id=u.id AND u2e.is_verify=1 WHERE u.username=:username UNION SELECT :username as email)
			GROUP BY e.id)
		
			UNION ALL
		
			(SELECT e.genre AS genre, e.id AS id, e.title AS title, e.organization_name as organization_name, u.username as email, e.location AS location, e.country_code AS countryCode, e.state_code AS stateCode, e.text_short_description AS description, '0' AS isEndorsed, '' AS faIcon,
			UNIX_TIMESTAMP( CONCAT( e.year_start, '-', COALESCE(e.month_start, 1), '-', '1' ) ) AS dateStarted,
			e.year_start AS yearStart, e.month_start AS monthStart, MONTHNAME( CONCAT( e.year_start, '-', e.month_start, '-', '1' ) ) AS monthNameStart,
			e.year_end AS yearEnd, e.month_end AS monthEnd 
			FROM `cv_experience` as e 
			LEFT JOIN cv_portfolio as f ON f.id=e.cv_portfolio_id 
			LEFT JOIN user as u ON f.user_id=u.id 
			WHERE e.is_active=1 AND u.username=:username
			GROUP BY e.id
			)
		) results ORDER BY dateStarted DESC LIMIT :limit OFFSET :offset";

		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':username', $this->user->username, PDO::PARAM_STR);
		$command->bindValue(':limit', $limit, PDO::PARAM_INT);
		$command->bindValue(':offset', ($page - 1) * $limit, PDO::PARAM_INT);

		$return = $command->queryAll();

		foreach ($return as &$r) {
			if ($r['isEndorsed'] != '1') {
				$experience = CvExperience::model()->findByPk($r['id']);
				$r['faIcon'] = $experience->getFaIcon();
			}
		}

		return $return;
	}

	public function cmp($a, $b)
	{
		if ($a['ym'] == $b['ym']) {
			return 0;
		}

		return ($a['ym'] < $b['ym']) ? -1 : 1;
	}

	public function getDistinctSkillset()
	{
	}

	public static function isSlugExists($slug)
	{
		$exists = self::slug2obj($slug);
		if ($exists === null) {
			return false;
		}

		return $exists->id;
	}

	public static function slug2obj($slug)
	{
		return CvPortfolio::model()->find('t.slug=:slug', array(':slug' => trim($slug)));
	}

	public static function getLookingList()
	{
		return array(
			array('code' => 'fulltime', 'title' => 'Full Time'),
			array('code' => 'contract', 'title' => 'Contract'),
			array('code' => 'freelance', 'title' => 'Freelance'),
			array('code' => 'cofounder', 'title' => 'Co-Founder'),
			array('code' => 'internship', 'title' => 'Internship'),
			array('code' => 'apprenticeship', 'title' => 'Apprenticeship'),
		);
	}

	public static function lookingCode2Title($code)
	{
		$tmp = self::getLookingList();
		foreach ($tmp as $t) {
			if ($t['code'] == $code) {
				return $t['title'];
			}
		}
	}

	public function isNotLookingAnything()
	{
		$return = true;
		$tmps = self::getLookingList();
		foreach ($tmps as $tmp) {
			$var = sprintf('is_looking_%s', $tmp['code']);
			if ($this->{$var} == 1) {
				return false;
			}
		}

		return $return;
	}

	public function getPublicUrl($controller, $isAbsoluteUrl = false)
	{
		if ($isAbsoluteUrl) {
			return $controller->createAbsoluteUrl('/cv/frontend/portfolio', array('slug' => $this->slug));
		} else {
			return $controller->createUrl('/cv/frontend/portfolio', array('slug' => $this->slug));
		}
	}

	public function hasLocalityInfo()
	{
		if (!empty($this->country_code) || !empty($this->state_code) || !empty($this->location)) {
			return true;
		}

		return false;
	}
}
