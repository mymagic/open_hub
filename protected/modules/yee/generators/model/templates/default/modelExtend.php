<?php
 /*************************************************************************
 * 
 * TAN YEE SIANG CONFIDENTIAL
 * __________________
 * 
 *  [2002] - [2007] TAN YEE SIANG
 *  All Rights Reserved.
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of TAN YEE SIANG and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to TAN YEE SIANG 
 * and its suppliers and may be covered by U.S. and Foreign Patents,
 * patents in process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from TAN YEE SIANG.
 */
 ?>
<?php echo "<?php\n"; ?>

class <?php echo $modelClass; ?> extends <?php echo $modelClass; ?>Base
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function init()
	{
		// custom code here
		// ...
		
		parent::init();

		// return void
	}

	public function beforeValidate() 
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate() 
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...
		
		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...
		
		parent::afterFind();
		
		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}
}
