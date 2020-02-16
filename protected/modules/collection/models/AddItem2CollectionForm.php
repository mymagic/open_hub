<?php

class AddItem2CollectionForm extends CFormModel
{
	public $tableName;
	public $itemId;
	public $collection = 'Default';
	public $collectionSub = 'Default';

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('tableName, itemId', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'tableName' => Yii::t('collection', 'Item Table'),
			'itemId' => Yii::t('collection', 'Item ID'),
			'collection' => Yii::t('collection', 'Collection'),
			'collectionSub' => Yii::t('collection', 'Sub Group'),
		);
	}
}
