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

class Setting extends SettingBase
{
	public $uploadPath;

	public $imageFile_value;

	public $uploadFile_value;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'setting';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code', 'length', 'max' => 64),
			array('datatype', 'length', 'max' => 7),
			array('imageFile_value', 'file', 'allowEmpty' => false, 'types' => 'jpeg, jpg, gif, png', 'maxSize' => 1024 * 1024 * 20, 'on' => 'updateImage'),
			array('uploadFile_value', 'file', 'allowEmpty' => false, 'maxSize' => 1024 * 1024 * 20, 'on' => 'updateFile'),
			array('value, datatype_value, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, value, datatype, datatype_value, note, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
		);
	}

	public function renderValue($model)
	{
		if ($model !== null) {
			$buffer = Setting::dataField($model);
			switch ($model->datatype) {
				case 'image':

					$buffer = Html::activeThumb($model, 'value');
					break;

				case 'file':

					if (!empty($model->value)) {
						$buffer = Html::activeFile($model, 'value');
					}
					break;
			}

			return $buffer;
		}
	}

	// reformat the model value base on the datatype
	// return: formatted value
	public function dataField($model)
	{
		if ($model !== null) {
			$buffer = $model->value;
			if ($model->value == '') {
				$buffer = null;
			}
			switch ($model->datatype) {
				case 'boolean':

					$buffer = ($model->value === '1');
					break;

				case 'integer':

					break;
			}

			return $buffer;
		}
	}

	public function isCodeExists($code)
	{
		$setting = Setting::model()->find('code=:code', array(':code' => $code));
		if ($setting === null) {
			return false;
		}

		return true;
	}

	// defaultValue: value to return if it is empty
	public static function code2value($code, $defaultValue = null)
	{
		$setting = Setting::model()->find('code=:code', array(':code' => $code));
		if ($setting === null) {
			return $defaultValue;
		}
		$value = Setting::dataField($setting);

		return $value;
	}

	public function figureGetEnumFunctionName($attribute)
	{
		return sprintf('getEnum%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute))));
	}

	public function getEnumValue($isNullable = false, $is4Filter = false)
	{
		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('code' => '', 'title' => '');
		}

		$datatypeValue = $this->datatype_value;
		$json = json_decode($datatypeValue);
		$options = $json->options;

		foreach ($options as $oKey => $oVal) {
			$result[] = array('code' => $oKey, 'title' => $oVal);
		}

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['code']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	// will auto initialize module setting, auto create if not exists, else just ignore
	// code should come with prefix with moduleKey infront, eg: boilerplateStart-var1
	// dataType: image, integer, boolean, float, string, text, html, array, enum, date, file
	public static function setSetting($code, $value, $dataType = '', $dataTypeValue = '')
	{
		// new record
		if (!self::isCodeExists($code)) {
			$setting = new Setting();
			$setting->code = $code;
			$setting->datatype = $dataType;
			$setting->datatype_value = $dataTypeValue;
		} else {
			$setting = self::model()->find('code=:code', array(':code' => $code));
		}

		$setting->value = $value;
		$setting->save();

		return $setting;
	}

	public static function deleteSetting($code)
	{
		$setting = self::model()->find('code=:code', array(':code' => $code));
		if ($setting) {
			return $setting->delete();
		}
	}
}
