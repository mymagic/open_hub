<?php

class City extends CityBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function toApi()
	{
		return array(
			'id' => $this->id,
			'stateCode' => $this->state_code,
			'title' => $this->title,
		);
	}
}
