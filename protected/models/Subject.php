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

class Subject extends SubjectBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('program_id, email, full_name', 'required'),
			array('program_id, is_registered, is_attended, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('email, full_name', 'length', 'max'=>128),
			array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, program_id, email, full_name, is_registered, is_attended, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
		);
	}
	
	public function isExists($programId, $email)
	{
		return Subject::model()->exists('program_id=:programId AND email=:email', array(":programId"=>$programId, ":email"=>$email));
	}
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('program_id',$this->program_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('is_registered',$this->is_registered);
		$criteria->compare('is_attended',$this->is_attended);
		$criteria->compare('json_extra',$this->json_extra,true);
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
			'sort'=>array(
				'defaultOrder'=>'t.id DESC',
			),
		));
	}
}
