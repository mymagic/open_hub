<?php

class Form extends FormBase
{
	public $searchIntake;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// custom code here
		// ...
		if (empty($this->timezone)) {
			$this->timezone = 'Asia/Kuala_Lumpur';
		}

		parent::init();

		// return void
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, date_open, date_close, title, type', 'required'),
			array('date_open, date_close, is_multiple, is_login_required, is_active, date_modified, date_added', 'numerical', 'integerOnly' => true),
			array('code, slug', 'length', 'max' => 64),
			array('title', 'length', 'max' => 255),
			array('timezone', 'length', 'max' => 128),
			// ys: override to add json_structure and json_stage as they are not standard way the framework handle json (do not have a fixed structure)
			array('text_short_description, text_note, json_structure, json_stage, json_event_mapping', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, slug, date_open, date_close, json_structure, json_stage, is_multiple, is_login_required, title, text_short_description, is_active, timezone, date_modified, date_added, sdate_open, edate_open, sdate_close, edate_close, sdate_modified, edate_modified, sdate_added, edate_added', 'safe', 'on' => 'search'),
			// meta
			array('_dynamicData', 'safe'),
		);
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
		$return['text_short_description'] = Yii::t('app', 'Short Description');
		$return['is_multiple'] = Yii::t('app', 'Allow multiple submission');
		$return['json_structure'] = Yii::t('app', 'Form Structure');
		$return['json_stage'] = Yii::t('app', 'Stage Pipeline');
		$return['json_event_mapping'] = Yii::t('app', 'Event Mapping Instruction');

		return $return;
	}

	public function isAvailableForPublic()
	{
		if (empty($this->slug)) {
			return false;
		}
		if (!$this->is_active) {
			return false;
		}

		return true;
	}

	public function getPublicUrl($params = array())
	{
		if (!empty($this->slug)) {
			$params['slug'] = $this->slug;

			return Yii::app()->createAbsoluteUrl('f7/publish/index', $params);
		}
	}

	public function getPublicUrlView($params = array())
	{
		if (!empty($this->slug)) {
			$params['slug'] = $this->slug;

			return Yii::app()->createAbsoluteUrl('f7/publish/view', $params);
		}
	}

	public function getPublicUrlEdit($params = array())
	{
		if (!empty($this->slug)) {
			$params['slug'] = $this->slug;

			return Yii::app()->createAbsoluteUrl('f7/publish/edit', $params);
		}
	}

	public function getPublicUrlConfirm($params = array())
	{
		if (!empty($this->slug)) {
			$params['slug'] = $this->slug;

			return Yii::app()->createAbsoluteUrl('f7/publish/confirm', $params);
		}
	}

	public function hasIntake()
	{
		if (!empty($this->form2intakes)) {
			return true;
		}

		return false;
	}

	public function getIntake()
	{
		if ($this->hasIntake()) {
			return $this->form2intakes[0]->intake;
		}

		return null;
	}

	public function hasUserSubmission($userId)
	{
		$submissions = self::getUserSubmission($userId);
		if (!empty($submissions)) {
			return true;
		}

		return false;
	}

	public function getUserSubmission($userId)
	{
		return $submissions = FormSubmission::model()->findAllByAttributes(array('user_id' => $userId, 'form_code' => $this->code));
	}

	public function getTimezone()
	{
		return $this->timezone;
	}

	public function renderStages($mode = 'text')
	{
		$stages = array();
		$buffer = '';
		if (!empty($this->json_stage)) {
			foreach ($this->jsonArray_stage as $stage) {
				if ($mode == 'html') {
					$stages[] = sprintf('<span class="label">%s</span>', $stage->title);
				} else {
					$stages[] = $stage->title;
				}
			}
		}

		$buffer = implode(' > ', $stages);

		return $buffer;
	}

	public function hasStage()
	{
		if (!empty($this->jsonArray_stage)) {
			return true;
		}

		return false;
	}

	public function isApplicationClosed()
	{
		$now = new DateTime('now');
		$close = new DateTime(date('r', $this->date_close));
		$open = new DateTime(date('r', $this->date_open));
		$diff = $close->getTimestamp() - $now->getTimestamp();
		if ($diff < 0) {
			$error = 'Please note that the submission date is passed and you are not allowed to submit anymore.';
			$this->addError($error, $error);

			return true;
		}

		$diff = $now->getTimestamp() - $open->getTimestamp();
		if ($diff < 0) {
			$openFormated = $this->renderDateOpen();
			$error = "Please note that the form will be ready for submission from $openFormated.";
			$this->addError($error, $error);

			return true;
		}

		return false;
	}

	public static function getEmptyForm()
	{
		return '<form class="col-lg-9"></form>';
	}

	public function slug2obj($slug)
	{
		return Form::model()->findByAttributes(array('slug' => $slug));
	}

	public function code2obj($code)
	{
		return Form::model()->findByAttributes(array('code' => $code));
	}

	public function id2obj($id)
	{
		return Form::model()->findByAttributes(array('id' => $id));
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->title = $keyword;
		$this->text_short_description = $keyword;
		$this->slug = $keyword;
		// $this->searchIntake = $keyword;

		$tmp = $this->search(array('compareOperator' => 'OR'));

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria;
		$criteria->together = true;

		$criteria->compare('id', $this->id, false, $params['compareOperator']);
		$criteria->compare('code', $this->code, true, $params['compareOperator']);
		$criteria->compare('slug', $this->slug, true, $params['compareOperator']);
		if (!empty($this->sdate_open) && !empty($this->edate_open)) {
			$sTimestamp = strtotime($this->sdate_open);
			$eTimestamp = strtotime("{$this->edate_open} +1 day");
			$criteria->addCondition(sprintf('date_open >= %s AND date_open < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_close) && !empty($this->edate_close)) {
			$sTimestamp = strtotime($this->sdate_close);
			$eTimestamp = strtotime("{$this->edate_close} +1 day");
			$criteria->addCondition(sprintf('date_close >= %s AND date_close < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		// $criteria->compare('json_structure', $this->json_structure, true, $params['compareOperator']);
		// $criteria->compare('json_stage', $this->json_stage, true, $params['compareOperator']);
		$criteria->compare('is_multiple', $this->is_multiple, false, $params['compareOperator']);
		$criteria->compare('is_login_required', $this->is_login_required, false, $params['compareOperator']);
		$criteria->compare('title', $this->title, true, $params['compareOperator']);
		$criteria->compare('text_short_description', $this->text_short_description, true, $params['compareOperator']);
		$criteria->compare('is_active', $this->is_active, false, $params['compareOperator']);
		$criteria->compare('timezone', $this->timezone, true, $params['compareOperator']);
		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		$criteria->compare('type', $this->type, false, $params['compareOperator']);
		$criteria->compare('text_note', $this->text_note, true, $params['compareOperator']);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
	}

	public function clearAllSubmissions()
	{
		foreach ($this->formSubmissions as $submission) {
			$submission->delete();
		}
	}
}
