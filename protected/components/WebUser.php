<?php
 
// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser 
{
	// Store model to not repeat query.
	private $_model;
	public $loginUrl = "";
	public $language;
	
	public function init()
	{
		$this->language = Yii::app()->language;
		parent::init();
	}
	
	// Load user model.
	protected function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null) $this->_model=User::model()->findByPk($id);
		}
		return $this->_model;
	}
}
?>