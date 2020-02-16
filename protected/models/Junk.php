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

class Junk extends JunkBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, content, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
		);
	}

	public function createNew($code, $content='')
	{
		$junk = new Self;
		$junk->code = $code;
		$junk->content = $content;
		return $junk->save();
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('content',$this->content,true);
		if(!empty($this->sdate_added) && !empty($this->edate_added))
		{
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified))
		{
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.date_added DESC',)
		));
	}

	public function renderContent()
	{
		if(ysUtil::isJson($this->content))
		{
			return json_encode(json_decode($this->content), JSON_PRETTY_PRINT);
		}
		return $this->content;
	}

	
	protected function afterSave()
	{
		// custom code here
		// ...
		if($this->isNewRecord) $this->onJunkCreated(new CEvent($this));

		return parent::afterSave();
	}

    function onJunkCreated($event)
    {
        $this->raiseEvent(__FUNCTION__, $event);
	}
	
}
