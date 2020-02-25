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

class IdeaRfp extends IdeaRfpBase
{
	public $enterpriseOrganizationCode;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_organization_code, title', 'required', 'on' => 'init'),
			array('partner_organization_code, title, html_content', 'required', 'on' => 'send'),
			array('date_added, date_modified, date_transacted', 'numerical', 'integerOnly' => true),
			array('amount, amount_local, amount_convert_rate', 'numerical'),
			array('partner_organization_code', 'length', 'max' => 64),
			array('title', 'length', 'max' => 255),
			array('status', 'length', 'max' => 8),
			array('currency', 'length', 'max' => 3),
			array('text_background, text_scope, text_schedule, text_staff, text_cost, text_supporting', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, partner_organization_code, title, html_content, text_background, text_scope, text_schedule, text_staff, text_cost, text_supporting, status, amount, amount_local, currency, amount_convert_rate, date_added, date_modified, date_transacted, sdate_added, edate_added, sdate_modified, edate_modified, sdate_transacted, edate_transacted', 'safe', 'on' => 'search'),

			array('enterpriseOrganizationCode', 'safe'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'enterprises' => array(self::MANY_MANY, 'Organization', 'idea_rfp2enterprise(idea_rfp_id, enterprise_organization_code)'),
			//'partnerOrganization' => array(self::BELONGS_TO, 'Organization', 'partner_organization_code'),
			'partner' => array(self::BELONGS_TO, 'Organization', 'partner_organization_code'),
			'enterprise' => array(self::BELONGS_TO, 'Organization', 'enterpriseOrganizationCode'),
			'proofs' => array(self::HAS_MANY, 'Proof', 'ref_id',
				'condition' => 'proofs.ref_table=:refTable',
				'params' => array(':refTable' => 'idea_rfp'),
				'order' => 'proofs.date_modified DESC'
			),
		);
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();
		$return['partner_organization_code'] = Yii::t('app', 'From Partner');
		$return['enterpriseOrganizationCode'] = Yii::t('app', 'To Enterprise');
		$return['title'] = Yii::t('app', 'RFP Title');
		$return['html_content'] = Yii::t('app', 'RFP Description');

		$return['text_background'] = Yii::t('app', 'Background');
		$return['text_scope'] = Yii::t('app', 'Scope');
		$return['text_schedule'] = Yii::t('app', 'Schedule');
		$return['text_staff'] = Yii::t('app', 'Staff');
		$return['text_cost'] = Yii::t('app', 'Budget');
		$return['text_supporting'] = Yii::t('app', 'Supporting Info');

		$return['amount_local'] = Yii::t('app', 'Local Amount');
		$return['currency'] = Yii::t('app', 'Currency code for this local Amount');

		// meta
		$return = array_merge($return, array_keys($this->_dynamicFields));
		foreach ($this->_metaStructures as $metaStruct) {
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}

		return $return;
	}

	public function toApi($params = '')
	{
		$return = array(
			'id' => $this->id,
			//'productId' => $this->product_id,
			'partnerOrganizationCode' => $this->partner_organization_code,
			'title' => $this->title,
			'htmlContent' => $this->html_content,

			'textBackground' => $this->text_background,
			'textScope' => $this->text_scope,
			'textSchedule' => $this->text_schedule,
			'textStaff' => $this->text_staff,
			'textCost' => $this->text_cost,
			'textSupporting' => $this->text_supporting,

			'status' => $this->status,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'dateTransacted' => $this->date_transacted,
			'fDateTransacted' => $this->renderDateTransacted(),

			'amount' => $this->amount,
			'amountLocal' => $this->amount_local,
			'currency' => $this->currency,
			'amountConvertRate' => $this->amount_convert_rate,
		);

		/*if(!in_array('-product', $params) && !empty($this->product))
		{
			$return['product'] = $this->product->toApi();
		}*/
		if (!in_array('-partner', $params) && !empty($this->partner)) {
			$return['partner'] = $this->partner->toApi(array('-products'));
		}
		if (!in_array('-enterprises', $params) && !empty($this->enterprises)) {
			foreach ($this->enterprises as $enterprise) {
				$return['enterprises'][] = $enterprise->toApi(array('-products'));
			}
		}

		return $return;
	}

	public function hasEnterprise($code)
	{
		foreach ($this->enterprises as $enterprise) {
			if ($enterprise->code == $code) {
				return true;
			}
		}

		return false;
	}

	public function canCancel()
	{
		if ($this->status == 'new' || $this->status == 'pending') {
			return true;
		}

		return false;
	}

	public function canSend()
	{
		if ($this->isDraft() && count($this->enterprises) >= 1) {
			return true;
		}

		return false;
	}

	public function isDraft()
	{
		if ($this->status == 'new' || $this->status == 'pending') {
			return true;
		}

		return false;
	}

	public function getEnumStatus($isNullable = false, $is4Filter = false, $htmlOptions = '')
	{
		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('code' => '', 'title' => $this->formatEnumStatus(''));
		}

		if (!empty($htmlOptions) && $htmlOptions['params']['mode'] == 'updateRfpStatus') {
			$result[] = array('code' => 'engaged', 'title' => $this->formatEnumStatus('engaged'));
			$result[] = array('code' => 'fail', 'title' => $this->formatEnumStatus('fail'));
		} else {
			$result[] = array('code' => 'new', 'title' => $this->formatEnumStatus('new'));
			$result[] = array('code' => 'pending', 'title' => $this->formatEnumStatus('pending'));
			$result[] = array('code' => 'engaging', 'title' => $this->formatEnumStatus('engaging'));
			$result[] = array('code' => 'engaged', 'title' => $this->formatEnumStatus('engaged'));
			$result[] = array('code' => 'cancel', 'title' => $this->formatEnumStatus('cancel'));
			$result[] = array('code' => 'fail', 'title' => $this->formatEnumStatus('fail'));
		}

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['code']] = $r['title'];
			}
			return $newResult;
		}

		return $result;
	}

	public function formatEnumStatus($code)
	{
		switch ($code) {
			case 'new': {return Yii::t('app', 'New'); break;}

			case 'pending': {return Yii::t('app', 'Pending'); break;}

			case 'engaging': {return Yii::t('app', 'Engaging'); break;}

			case 'engaged': {return Yii::t('app', 'Engaged'); break;}

			case 'cancel': {return Yii::t('app', 'Cancel'); break;}

			case 'fail': {return Yii::t('app', 'Unsuccessful'); break;}
			default: {return ''; break;}
		}
	}

	public function renderEnterprises($mode = 'text')
	{
		$buffer = '';

		foreach ($this->enterprises as $enterprise) {
			$buffer .= sprintf("%s\n", $enterprise->title);
		}
		if ($mode == 'html') {
			$buffer = nl2br($buffer);
		}

		return $buffer;
	}

	public function renderStatus($mode = 'text')
	{
		$buffer = '';
		$accent = 'default';
		if ($this->isDraft()) {
			$accent = 'default';
		}
		if ($this->status == 'engaging') {
			$accent = 'warning';
		}
		if ($this->status == 'engaged') {
			$accent = 'success';
		}
		if ($this->status == 'fail') {
			$accent = 'danger';
		}

		if ($mode == 'html') {
			$buffer .= sprintf('<span class="label label-%s">', $accent);
		}
		if ($this->isDraft()) {
			$buffer .= 'Draft';
		} else {
			$buffer .= strtoupper($this->formatEnumStatus($this->status));
		}

		if ($mode == 'html') {
			$buffer .= '</span>';
		}

		return $buffer;
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('partner_organization_code', $this->partner_organization_code, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('html_content', $this->html_content, true);
		$criteria->compare('text_background', $this->text_background, true);
		$criteria->compare('text_scope', $this->text_scope, true);
		$criteria->compare('text_schedule', $this->text_schedule, true);
		$criteria->compare('text_staff', $this->text_staff, true);
		$criteria->compare('text_cost', $this->text_cost, true);
		$criteria->compare('text_supporting', $this->text_supporting, true);
		$criteria->compare('status', $this->status);
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
		if (!empty($this->sdate_transacted) && !empty($this->edate_transacted)) {
			$sTimestamp = strtotime($this->sdate_transacted);
			$eTimestamp = strtotime("{$this->edate_transacted} +1 day");
			$criteria->addCondition(sprintf('date_transacted >= %s AND date_transacted < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('amount', $this->amount);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
			),
		));
	}

	protected function beforeSave()
	{
		// custom code here
		// ...
		if ($this->status == 'fail' || $this->status == 'cancel') {
			$this->date_transacted = null;
			$this->amount = null;
		}

		return parent::beforeSave();
	}
}
