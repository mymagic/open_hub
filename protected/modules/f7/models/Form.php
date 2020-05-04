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

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form2intakes' => array(self::HAS_MANY, 'Form2Intake', 'form_id'),
			'intakes' => array(self::HAS_MANY, 'Intake', 'intake_id', 'through' => 'form2intakes'),
			'formSubmissions' => array(self::HAS_MANY, 'FormSubmission', 'form_code'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
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

		$tmp = $this->search(array('compareOperator' => 'OR'));
		$tmp->sort->defaultOrder = 't.is_active DESC, t.date_open DESC';

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria();
		$criteria->together = true;

		$criteria->compare('t.id', $this->id, false, $params['compareOperator']);
		$criteria->compare('t.code', $this->code, true, $params['compareOperator']);
		$criteria->compare('t.slug', $this->slug, true, $params['compareOperator']);
		$criteria->compare('t.title', $this->title, true, $params['compareOperator']);
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

		$criteria->compare('t.text_short_description', $this->text_short_description, true, $params['compareOperator']);
		$criteria->compare('t.is_active', $this->is_active, false, $params['compareOperator']);
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

		// either form or intake title
		$criteria2 = new CDbCriteria();
		$criteria2->together = true;
		$criteria2->with = ['intakes'];
		$criteria2->compare('intakes.title', $this->title, true, 'OR');
		$criteria->mergeWith($criteria2, 'OR');

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

	public function toApi($params = null)
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'slug' => $this->slug,
			'dateOpen' => $this->date_open,
			'fDateOpen' => $this->renderDateOpen(),
			'fDateOpenDateOnly' => $this->renderDateOpen('date'),
			'fDateOpenTimeOnly' => $this->renderDateOpen('time'),
			'dateClose' => $this->date_close,
			'fDateClose' => $this->renderDateClose(),
			'fDateCloseDateOnly' => $this->renderDateClose('date'),
			'fDateCloseTimeOnly' => $this->renderDateClose('time'),
			//'jsonStructure' => $this->json_structure,
			'jsonStage' => $this->json_stage,
			'isMultiple' => $this->is_multiple,
			'isLoginRequired' => $this->is_login_required,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'isActive' => $this->is_active,
			'timezone' => $this->timezone,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'type' => $this->type,
			'textNote' => $this->text_note,
			'jsonEventMapping' => $this->json_event_mapping,
			'fCountDraftSubmissions' => $this->countDraftFormSubmissions(),
			'fCountSubmittedSubmissions' => $this->countSubmittedFormSubmissions(),
			'fCountWorkflowSubmissions' => $this->countWorkflowFormSubmissions(),
		);
		// json structure is too heavey to be part of api
		if (!in_array('-jsonStructure', $params)) {
			$return['jsonStructure'] = $this->json_structure;
		}
		if (!in_array('-jsonEventMapping', $params)) {
			$return['jsonEventMapping'] = $this->json_event_mapping;
		}

		// many2many
		if (!in_array('-intakes', $params) && !empty($this->intakes)) {
			foreach ($this->intakes as $intake) {
				$return['intakes'][] = $intake->toApi(['-form', $params['config']]);
			}
		}

		return $return;
	}

	public function renderDateOpen($format = '')
	{
		if ($format == 'date') {
			return Html::formatDateTimezone($this->date_open, 'standard', '', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == 'time') {
			return Html::formatDateTimezone($this->date_open, '', 'standard', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == '') {
			return Html::formatDateTimezone($this->date_open, 'standard', 'standard', '-', $this->getTimezone());
		}
	}

	public function renderDateClose($format = '')
	{
		if ($format == 'date') {
			return Html::formatDateTimezone($this->date_close, 'standard', '', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == 'time') {
			return Html::formatDateTimezone($this->date_close, '', 'standard', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == '') {
			return Html::formatDateTimezone($this->date_close, 'standard', 'standard', '-', $this->getTimezone());
		}
	}

	public function countDraftFormSubmissions()
	{
		// stat without primary key linkage is not working
		$command = Yii::app()->db->createCommand()->select('count(id)')->from('form_submission')->where('form_code=:formCode AND status=:status', array(':formCode' => $this->code, ':status' => 'draft'));

		return $command->queryScalar();
	}

	public function countSubmittedFormSubmissions()
	{
		// stat without primary key linkage is not working
		$command = Yii::app()->db->createCommand()->select('count(id)')->from('form_submission')->where('form_code=:formCode AND status=:status', array(':formCode' => $this->code, ':status' => 'submit'));

		return $command->queryScalar();
	}

	public function countWorkflowFormSubmissions()
	{
		$return = null;

		$stages = Yii::app()->db->createCommand()->select('DISTINCT(stage)')->from('form_submission')->where('form_code=:formCode', array(':formCode' => $this->code))->queryAll();

		foreach ($stages as $stage) {
			$key = $stage['stage'];
			if ($stage['stage'] == '') {
				$key = 'EMPTY';
			}
			// stat without primary key linkage is not working
			$command = Yii::app()->db->createCommand()->select('count(id)')->from('form_submission')->where('form_code=:formCode AND stage=:stage', array(':formCode' => $this->code, ':stage' => $stage['stage']));
			$return[$key] = $command->queryScalar();
		}

		return $return;
	}
}
