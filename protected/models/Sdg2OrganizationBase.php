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
 * This is the model class for table "role2user".
 *
 * The followings are the available columns in table 'role2user':
		 * @property integer $role_id
		 * @property integer $user_id
 */

class Sdg2OrganizationBase extends ActiveRecordBase
{
	public $uploadPath;

	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'sdg2organization';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sdg2organization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sdg_id, organization_id', 'required'),
			array('sdg_id, organization_id', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sdg_id, organization_id', 'safe', 'on' => 'search'),
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
		'sdg_id' => Yii::t('app', 'Sdg'),
		'organization_id' => Yii::t('app', 'Organization'),
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

		$criteria->compare('sdg_id', $this->sdg_id);
		$criteria->compare('organization_id', $this->organization_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function scopes()
	{
		return array(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Role2user the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
