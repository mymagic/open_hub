<?php

class Role extends RoleBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'match', 'pattern'=>'/^([a-zA-Z0-9_-])+$/', 'message'=>Yii::t('default', '{attribute} only accept valid character set like a-z, A-Z, 0-9, - and _')),
			array('code, title', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>64),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, date_added, date_modified', 'safe', 'on'=>'search'),

		);
	}
	
	public function code2id($code)
	{
		$role = Role::model()->find('t.code=:code', array(':code'=>$code));
		if(!empty($role))
		{
			return $role->id;
		}
	}
}
