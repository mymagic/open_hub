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

class Proof extends ProofBase
{
	public $uploadPath;

	public $imageFile_value;

	public $uploadFile_value;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_username'),
		);
	}

	public function init()
	{
		// custom code here
		// ...
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'proof';

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
		$return['imageFile_value'] = Yii::t('app', 'Image');
		$return['uploadFile_value'] = Yii::t('app', 'File');

		return $return;
	}

	public function renderValue($mode = 'text')
	{
		switch ($this->datatype) {
			case 'image':
			{
				return Html::activeThumb($this, 'value');
				break;
			}
			case 'file':
			{
				if (!empty($this->value)) {
					return Html::activeFile($this, 'value');
				}
				break;
			}
			case 'string':
			{
				return $this->value;
				break;
			}
		}
	}

	public function getUrl($mode = '')
	{
		if ($mode == 'backendEdit') {
		} elseif ($mode == 'return2Record') {
			switch ($this->ref_table) {
				case 'idea_rfp': { return Yii::app()->createUrl('/idea/ideaRfp/view', array('id' => $this->ref_id));}
				case 'organization_funding': { return Yii::app()->createUrl('/organizationFunding/view', array('id' => $this->ref_id));}
				case 'organization_revenue': { return Yii::app()->createUrl('/organizationRevenue/view', array('id' => $this->ref_id));}
				case 'organization_status': { return Yii::app()->createUrl('/organizationStatus/view', array('id' => $this->ref_id));}
			}
		}
		// backendView
		else {
			return Yii::app()->createUrl('/proof/view', array('id' => $this->id));
		}
	}

	public function getForRecord($refTable, $refId)
	{
		switch ($refTable) {
			case 'idea_rfp':
			{
				return IdeaRfp::model()->findByPk($refId);
			}
			case 'organization_funding':
			{
				return OrganizationFunding::model()->findByPk($refId);
			}
			case 'organization_revenue':
			{
				return OrganizationRevenue::model()->findByPk($refId);
			}
			case 'organization_status':
			{
				return OrganizationStatus::model()->findByPk($refId);
			}
		}
	}

	public function getEnumDatatype($isNullable = false, $is4Filter = false)
	{
		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('code' => '', 'title' => $this->formatEnumDatatype(''));
		}

		// $result[] = array('code'=>'string', 'title'=>$this->formatEnumDatatype('string'));
		$result[] = array('code' => 'image', 'title' => $this->formatEnumDatatype('image'));
		$result[] = array('code' => 'file', 'title' => $this->formatEnumDatatype('file'));

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['code']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}
}
