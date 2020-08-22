<?php


/**
 * This is the model class for table "role2access".
 *
 * The followings are the available columns in table 'role2access':
		 * @property integer $role_id
		 * @property integer $access_id
 */

class Role2AccessBase extends ActiveRecordBase
{
	public $uploadPath;

	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'role2access';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role2access';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, access_id', 'required'),
			array('role_id, access_id', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_id, access_id', 'safe', 'on' => 'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		'role_id' => Yii::t('app', 'Role'),
		'access_id' => Yii::t('app', 'Access'),
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

		$criteria = new CDbCriteria;

		$criteria->compare('role_id', $this->role_id);
		$criteria->compare('access_id', $this->access_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function scopes()
	{
		return array(
			//'isActive'=>array('condition'=>"t.is_active = 1"),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Role2Access the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
