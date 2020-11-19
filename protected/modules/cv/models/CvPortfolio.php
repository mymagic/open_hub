<?php

class CvPortfolio extends CvPortfolioBase
{
	public $url_website;
	public $url_linkedin;
	public $url_twitter;
	public $url_facebook;
	public $url_github;
	public $url_stackoverflow;

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
			array('user_id, jobpos_id, high_academy_experience_id, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('organization_name, location, display_name, image_avatar', 'length', 'max' => 255),
			array('state_code', 'length', 'max' => 12),
			array('country_code', 'length', 'max' => 2),
			array('text_oneliner', 'length', 'max' => 200),
			array('visibility', 'length', 'max' => 9),
			array('text_address_residential, latlong_address_residential, text_short_description', 'safe'),
			array('imageFile_avatar', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, slug, jobpos_id, organization_name, location, text_address_residential, latlong_address_residential, state_code, country_code, display_name, image_avatar, high_academy_experience_id, text_oneliner, text_short_description, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, visibility, is_active, json_social, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified, url_website, url_linkedin, url_twitter, url_facebook, url_github, url_stackoverflow', 'safe', 'on' => 'search'),
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
			'cvJobpos' => array(self::BELONGS_TO, 'CvJobpos', 'jobpos_id'),
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
		'jobpos_id' => Yii::t('app', 'Job Role'),
		'location' => Yii::t('app', 'Location'),
		'state_code' => Yii::t('app', 'State'),
		'country_code' => Yii::t('app', 'Country'),
		'display_name' => Yii::t('app', 'Display Name'),
		'image_avatar' => Yii::t('app', 'Avatar'),
		'text_short_description' => Yii::t('app', 'Short Description'),
		'text_address_residential' => Yii::t('app', 'Current Address'),
		'latlong_address_residential' => Yii::t('app', 'Current Address Location'),
		'text_onliner' => Yii::t('app', 'Oneliner'),
		//'high_academy_experience_id' => Yii::t('app', 'Highest Academy'),
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

	public function getRegisteredPrograms()
	{
		$sql = sprintf('SELECT e.*, YEAR(FROM_UNIXTIME(date_started)) AS year_start, MONTH(FROM_UNIXTIME(date_started)) AS month_start, 
			YEAR(FROM_UNIXTIME(date_ended)) AS year_end, MONTH(FROM_UNIXTIME(date_ended)) AS month_end
			FROM `event` as e, `event_registration` as er, cv_portfolio as f, user as u, user2email as u2e 
			WHERE e.is_active=1 AND e.is_cancelled=0 AND f.user_id=u.id AND e.id=er.event_id AND (er.email=u.username OR (u.id=f.user_id AND u2e.is_verify=1 AND er.email=u2e.user_email)) AND u.username="%s"
			GROUP BY e.id ORDER BY e.date_started DESC', $this->user->username);
		//echo $sql;exit;
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function getAttendedPrograms()
	{
		$sql = sprintf('SELECT e.*, YEAR(FROM_UNIXTIME(date_started)) AS year_start, MONTH(FROM_UNIXTIME(date_started)) AS month_start, 
			YEAR(FROM_UNIXTIME(date_ended)) AS year_end, MONTH(FROM_UNIXTIME(date_ended)) AS month_end
			FROM `event` as e, `event_registration` as er, cv_portfolio as f, user as u, user2email as u2e 
			WHERE e.is_active=1 AND e.is_cancelled=0 AND er.is_attended=1 AND f.user_id=u.id AND e.id=er.event_id AND (er.email=u.username OR (u.id=f.user_id AND u2e.is_verify=1 AND er.email=u2e.user_email)) AND u.username="%s"
			GROUP BY e.id ORDER BY e.date_started DESC', $this->user->username);
		//echo $sql;exit;
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function getComposedExperiences()
	{
		$programs = $this->getAttendedPrograms();

		$experiences = $this->activeCvExperiencesSorted;
		foreach ($programs as $p) {
			$items[] = array('ym' => $p['year_start'] . sprintf('%02d', $p['month_start']), 'type' => 'program',
				'year_start' => $p['year_start'], 'month_start' => $p['month_start'], 'year_end' => $p['year_end'], 'month_end' => $p['month_end'],
				'title' => $p['title'], 'genre' => 'others', 'country_code' => $p['country_code'], 'state_code' => $p['state_code'], 'location' => $p['at'], 'text_short_desciption' => '', 'organization_name' => $p['organization_name'],
				'faIcon' => 'fa-star text-warning', 'is_endorsed' => true,
				//'node'=>$p,
			);
		}
		foreach ($experiences as $e) {
			$items[] = array('ym' => $e['year_start'] . sprintf('%02d', $e['month_start']), 'type' => 'experience',
				'year_start' => $e['year_start'], 'month_start' => $e['month_start'], 'year_end' => $e['year_end'], 'month_end' => $e['month_end'],
				'title' => $e->title, 'genre' => $e->genre, 'country_code' => $e->country_code, 'state_code' => $e->state_code, 'location' => $e->location, 'text_short_desciption' => $e->text_short_description, 'organization_name' => $e->organization_name,
				'faIcon' => $e->getFaIcon(), 'is_endorsed' => false,
				//'node'=>$e,
			);
		}
		usort($items, 'self::cmp');
		$items = array_reverse($items);

		return $items;
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
}
