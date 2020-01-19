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
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class EventOrganizationBulkInsertForm extends CFormModel
{
	public $event_id;
	public $file_excel;
	public $uploadFile_excel;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('event_id', 'required'),
            array('uploadFile_excel', 'file', 'types'=>'xls, xlsx', 'allowEmpty'=>false),
            array('event_id, file_excel', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'event_id'=>Yii::t('core', 'Event'),
			'uploadFile_excel'=>Yii::t('core', 'Excel'),
		);
	}

	
}
