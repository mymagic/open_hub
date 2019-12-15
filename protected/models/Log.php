<?php

class Log extends LogBase
{
	public $username, $full_name;
	
	public static function model($class = __CLASS__){return parent::model($class);}
	
	
	public function init()
    {
		$this->ip =  Yii::app()->request->userHostAddress;
		$this->agent_string = Yii::app()->request->userAgent;
		$this->url_referrer = Yii::app()->request->urlReferrer;
		$this->url_current = Yii::app()->request->url;
		$this->user_id =  Yii::app()->user->id;
		$this->controller =  Yii::app()->controller->id;
		$this->action =  Yii::app()->controller->action->id;
		$this->is_admin = !empty(Yii::app()->user->accessBackend) && Yii::app()->user->accessBackend?1:'';
		$this->is_member = (!$this->is_admin && !Yii::app()->user->isGuest)?1:'';
		//$this->is_user = (!$this->is_admin && !Yii::app()->user->isGues)?1:'';
		$get = $_GET;
		$post = $_POST;
		$this->json_params = json_encode(array('GET'=>$get, 'POST'=>$post));
	}
	
	public function rules()
	{
		$rules = parent::rules();
		$rules[5][0] = $rules[5][0] . ", username, full_name";
		return $rules;
	}
	
	public function writeLog($textNote='')
	{
		$log = new Log();
		if(!empty($textNote)) $log->text_note = $textNote;
		$log->save();
	}
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('user', 'user.profile');
		$criteria->together = true;
		
		$criteria->compare('user.username', $this->username, true);
		$criteria->compare('profile.full_name', $this->full_name, true);

		$criteria->compare('t.ip',$this->ip,true);
		$criteria->compare('t.agent_string',$this->agent_string,true);
		$criteria->compare('t.url_referrer',$this->url_referrer,true);
		$criteria->compare('t.url_current',$this->url_current,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.is_admin',$this->is_admin);
		$criteria->compare('t.is_member',$this->is_member);
		$criteria->compare('t.controller',$this->controller,true);
		$criteria->compare('t.action',$this->action,true);
		$criteria->compare('t.json_params',$this->json_params,true);
		$criteria->compare('t.text_note',$this->text_note,true);
		$criteria->compare('t.date_added',$this->date_added);
		$criteria->compare('t.date_modified',$this->date_modified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.date_added DESC',)
		));
	}
	
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if(empty($this->ip))
			{
				$this->ip =  Yii::app()->request->userHostAddress;
			}
			if(empty($this->agent_string) && !empty(Yii::app()->request->userAgent))
			{
				$this->agent_string = Yii::app()->request->userAgent;
			}
			if(empty($this->url_referrer) && !empty(Yii::app()->request->urlReferrer))
			{
				$this->url_referrer = Yii::app()->request->urlReferrer;
			}
			if(empty($this->url_current) && !empty(Yii::app()->request->url))
			{
				$this->url_current = Yii::app()->request->url;
			}
			if(empty($this->user_id) && !empty(Yii::app()->user->id))
			{
				$this->user_id =  Yii::app()->user->id;
			}
			if(empty($this->is_admin))
			{
				$this->is_admin =  !empty(Yii::app()->user->accessBackend) && Yii::app()->user->accessBackend?1:'';
			}
			if(empty($this->is_member))
			{
				$this->is_member = (!$this->is_admin && !Yii::app()->user->isGuest)?1:'';
			}
			if(empty($this->controller) && !empty(Yii::app()->controller->id))
			{
				$this->controller =  Yii::app()->controller->id;
			}
			if(empty($this->action) && !empty(Yii::app()->controller->action->id))
			{
				$this->action =  Yii::app()->controller->action->id;
			}
			if(empty($this->json_params))
			{
				$get = $_GET;
				$post = $_POST;
				$this->json_params = json_encode(array('GET'=>$get, 'POST'=>$post));
			}
			
			// auto deal with date added and date modified
			if($this->isNewRecord)
			{
				$this->date_added=$this->date_modified=time();
			}
			else
			{
				$this->date_modified=time();
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}
}
