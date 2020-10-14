<?php

class FormSubmission extends FormSubmissionBase
{
	public $searchIntake;
	public $username;
	public $details;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// custom code here
		// ...

		parent::init();

		// return void
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, form_code, stage', 'required'),
			array('user_id, date_submitted, date_added, date_modified, date_processed', 'numerical', 'integerOnly' => true),
			array('code, form_code', 'length', 'max' => 64),
			array('status', 'length', 'max' => 6),
			array('stage', 'length', 'max' => 255),
			array('process_by', 'length', 'max' => 128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, form_code, username, details, json_data, status, stage, json_extra, process_by, date_submitted, date_added, date_modified, date_processed, sdate_submitted, edate_submitted, sdate_added, edate_added, sdate_modified, edate_modified, sdate_processed, edate_processed', 'safe', 'on' => 'search'),
			// meta
			array('_dynamicData', 'safe'),
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		$criteria->with = array('user');
		$criteria->compare('t.id', $this->id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('form_code', $this->form_code, true);
		$criteria->compare('user.username', $this->username, true);
		//$criteria->compare('json_data',$this->startup_search, true);
		//$criteria->compare('json_data',$this->json_data,true);
		$tmp = $this->details;
		if (!empty($this->details)) {
			$criteria->addSearchCondition('json_data', $this->details);
		}
		$criteria->compare('status', $this->status);
		$criteria->compare('stage', $this->stage, true);
		if (!empty($this->sdate_submitted) && !empty($this->edate_submitted)) {
			$sTimestamp = strtotime($this->sdate_submitted);
			$eTimestamp = strtotime("{$this->edate_submitted} +1 day");
			$criteria->addCondition(sprintf('date_submitted >= %s AND date_submitted < %s', $sTimestamp, $eTimestamp));
		}
		if (!empty($this->sdate_processed) && !empty($this->edate_processed)) {
			$sTimestamp = strtotime($this->sdate_processed);
			$eTimestamp = strtotime("{$this->edate_processed} +1 day");
			$criteria->addCondition(sprintf('date_processed >= %s AND date_processed < %s', $sTimestamp, $eTimestamp));
		}
		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,

			//'sort' => array('defaultOrder' => 't.id DESC'),

			'sort' => array(
				'attributes' => array(
					'username' => array(
						'asc' => 'user.username',
						'desc' => 'user.username DESC',
					),
					'*',
				),
			),
		));
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
		// custom code here
		// ...

		parent::afterFind();

		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}

	public function scopes()
	{
		return array(
			'draft' => array('condition' => "t.status = 'draft"),
			'submit' => array('condition' => "t.status = 'submit"),
		);
	}

	public function getEnumStage($isNullable = false, $is4Filter = false)
	{
		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('code' => '', 'title' => $this->formatEnumStage(''));
		}

		$stages = $this->form->jsonArray_stage;
		if (!empty($stages)) {
			foreach ($stages as $stage) {
				$result[] = array('code' => $stage->key, 'title' => $this->formatEnumStage($stage->key));
			}
		}

		//$result[] = array('code' => 'submit', 'title' => $this->formatEnumStatus('submit'));

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['code']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public function formatEnumStage($code)
	{
		$stages = $this->form->jsonArray_stage;
		if (!empty($stages)) {
			foreach ($stages as $stage) {
				if ($stage->key == $code) {
					return $stage->title;
				}
			}
		}

		return '';
	}

	public function renderJsonData($mode = 'html', $realm = 'frontend')
	{
		if ($mode == 'html') {
			$return = HubForm::convertJsonToHtml(false, $this->form->json_structure, $this->json_data, $this->form->slug, null, $realm);
		} elseif ($mode == 'csv') {
			$values = $headers = $return = array();
			$exportableCsvTags = array('googleplace', 'url', 'email', 'phone', 'textbox', 'number', 'textarea', 'list', 'checkbox', 'radio', 'booleanButton', 'upload',  'rating', );

			// prepand extra data about the submission
			$headers[] = 'ID';
			$values[] = $this->id;
			$headers[] = 'Code';
			$values[] = $this->code;
			$headers[] = 'From';
			$values[] = !empty($this->user) ? $this->user->username : '-';
			$headers[] = 'Stage';
			$values[] = $this->formatEnumStage($this->stage);
			$headers[] = 'Status';
			$values[] = $this->formatEnumStatus($this->status);
			$headers[] = 'Date Submitted';
			$values[] = Html::formatDateTimezone($this->date_submitted, 'long', 'medium', '-', $this->form->timezone);

			foreach ($this->form->jsonArray_structure as $structureItem) {
				if (is_object($structureItem) && property_exists($structureItem, 'members')) {
					foreach ($structureItem->members as $structureItemMember) {
						if (!empty($structureItemMember->tag) && !empty($structureItemMember->prop) && in_array($structureItemMember->tag, $exportableCsvTags)) {
							// $structureItemMember->prop->name eg: startup, website, fname, heard...
							if (!empty($structureItemMember->prop->csv_label)) {
								$headers[] = $structureItemMember->prop->csv_label;
							} else {
								$headers[] = $structureItemMember->prop->name;
							}

							//$values[] = $structureItemMember->prop->value;
							if ($structureItemMember->tag == 'upload') {
								$tmp = basename($this->jsonArray_data->{$structureItemMember->prop->name . '.aws_path'});
								if (!empty($tmp)) {
									$values[] = Yii::app()->createAbsoluteUrl('/f7/publish/download', array('filename' => $tmp));
								} else {
									$values[] = '-';
								}
							} else {
								if (is_array($this->jsonArray_data->{$structureItemMember->prop->name})) {
									$arrayString = '';
									foreach ($this->jsonArray_data->{$structureItemMember->prop->name} as $arrayItem) {
										$arrayString .= sprintf(" - %s\n", $arrayItem);
									}
									$values[] = $arrayString;
								} else {
									$values[] = sprintf('%s', $this->jsonArray_data->{$structureItemMember->prop->name});
								}
							}
						}
					}
				}
			}
			$return = array($headers, $values);

			return $return;
		} elseif ($mode == 'debug') {
			//echo '<pre>';print_r($this->form->jsonArray_structure) ;
		}

		return $return;

		//echo '<pre>';print_r($jsonStructure);exit;
	}

	public function formatEnumStatus($code)
	{
		switch ($code) {
			case 'draft': {return Yii::t('app', 'Draft'); break;}

			case 'submit': {return Yii::t('app', 'Submitted'); break;}
			default: {return ''; break;}
		}
	}

	public function renderStatus($mode = 'html')
	{
		if ($mode == 'html') {
			if ($this->status == 'draft') {
				return sprintf('<span class="label label-info">%s</span>', ucwords($this->status));
			} elseif ($this->status == 'submit') {
				return sprintf('<span class="label label-primary">%s</span>', ucwords('Submitted'));
			}
		}

		return ucwords($this->status);
	}

	public function renderStage($mode = 'html')
	{
		if ($mode == 'html') {
			if ($this->stage == 'rejected' || $this->stage == 'cancelled') {
				return sprintf('<span class="label label-danger">%s</span>', ucwords($this->stage));
			} elseif ($this->stage == 'approved' || $this->stage == 'accepted') {
				return sprintf('<span class="label label-primary">%s</span>', ucwords($this->stage));
			} else {
				return sprintf('<span class="label label-success">%s</span>', ucwords($this->stage));
			}
		}

		return ucwords($this->stage);
	}

	public function renderBackendDetails($mode = 'html')
	{
		$showableDetailTags = array('textbox', 'email', 'list');

		$buffer = '';
		//echo '<pre>';print_R($this->form->jsonArray_structure);exit;
		foreach ($this->form->jsonArray_structure as $structureItem) {
			if (is_object($structureItem) && property_exists($structureItem, 'members')) {
				foreach ($structureItem->members as $structureItemMember) {
					if (!empty($structureItemMember->tag) && !empty($structureItemMember->prop) && in_array($structureItemMember->tag, $showableDetailTags)) {
						if ($structureItemMember->prop->showinbackendlist == 1) {
							$buffer .= sprintf(
								"<b>%s:</b> %s\n",
							$structureItemMember->prop->csv_label,
								$this->jsonArray_data->{$structureItemMember->prop->name}
							);
						}
					}
				}
			}
		}

		if ($mode == 'html') {
			$buffer = nl2br($buffer);
		}

		if (!empty($buffer)) {
			return $buffer;
		} else {
			return '-';
		}
	}

	public function renderSimpleFormattedHtml()
	{
		$contentList = $this->renderJsonData('csv');
		$combinedList = array_combine($contentList[0], $contentList[1]);
		$excludeItems = array('Code');

		$return = '';

		foreach ($combinedList as $key => $value) {
			if (in_array($key, $excludeItems) || trim($value) == '') {
				continue;
			}
			$return .= sprintf('<p><b>%s</b><br />%s</p>', $key, nl2br($value));
		}

		$return = sprintf('<div>%s</div>', $return);

		return $return;
	}

	public function toApi($params = null)
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'formCode' => $this->form_code,
			'userId' => $this->user_id,
			'status' => $this->status,
			'stage' => $this->stage,
			'dateSubmitted' => $this->date_submitted,
			'fDateSubmitted' => $this->renderDateSubmitted(),
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'processBy' => $this->process_by,
			'dateProcessed' => $this->date_processed,
			'fDateProcessed' => $this->renderDateProcessed(),
		);

		if (!in_array('-jsonData', $params)) {
			$return['jsonData'] = $this->json_data;
		}
		if (!in_array('-jsonExtra', $params)) {
			$return['jsonExtra'] = $this->json_extra;
		}

		// many2many

		return $return;
	}
}
