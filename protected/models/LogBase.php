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


/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
		 * @property integer $id
		 * @property string $ip
		 * @property string $agent_string
		 * @property string $url_referrer
		 * @property string $url_current
		 * @property integer $user_id
		 * @property integer $is_admin
		 * @property integer $is_member
		 * @property string $controller
		 * @property string $action
		 * @property string $json_params
		 * @property string $text_note
		 * @property integer $date_added
		 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $user
 */
 
class LogBase extends ActiveRecordBase
{
	public $uploadPath;
	
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'log';
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, is_admin, is_member, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>24),
			array('agent_string, url_referrer, url_current', 'length', 'max'=>255),
			array('controller, action', 'length', 'max'=>32),
			array('json_params, text_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ip, agent_string, url_referrer, url_current, user_id, is_admin, is_member, controller, action, json_params, text_note, date_added, date_modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		'id' => Yii::t('app', 'ID'),
		'ip' => Yii::t('app', 'Ip'),
		'agent_string' => Yii::t('app', 'Agent String'),
		'url_referrer' => Yii::t('app', 'Url Referrer'),
		'url_current' => Yii::t('app', 'Url Current'),
		'user_id' => Yii::t('app', 'User'),
		'is_admin' => Yii::t('app', 'Is Admin'),
		'is_member' => Yii::t('app', 'Is Member'),
		'controller' => Yii::t('app', 'Controller'),
		'action' => Yii::t('app', 'Action'),
		'json_params' => Yii::t('app', 'Json Params'),
		'text_note' => Yii::t('app', 'Text Note'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('agent_string',$this->agent_string,true);
		$criteria->compare('url_referrer',$this->url_referrer,true);
		$criteria->compare('url_current',$this->url_current,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('is_admin',$this->is_admin);
		$criteria->compare('is_member',$this->is_member);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('json_params',$this->json_params,true);
		$criteria->compare('text_note',$this->text_note,true);
		$criteria->compare('date_added',$this->date_added);
		$criteria->compare('date_modified',$this->date_modified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Log the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{

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
