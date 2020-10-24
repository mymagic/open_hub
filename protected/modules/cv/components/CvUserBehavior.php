<?php

Yii::import('modules.cv.models.*');

// this allow you to inject method into user object
class CvUserBehavior extends Behavior
{
	// the user model
	public $model;

	public function hasCvPortfolio()
	{
		return CvPortfolio::model()->exists('t.user_id LIKE :userId', array(':userId' => $this->model->id));
	}

	public function getCvPortfolio()
	{
		return CvPortfolio::model()->find('t.user_id LIKE :userId', array(':userId' => $this->model->id));
	}
}
