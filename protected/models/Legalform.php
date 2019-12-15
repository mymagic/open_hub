<?php

class Legalform extends LegalformBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			'title' => $this->title,
			'countryCode' => $this->country_code,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
		);
			
		return $return;
	}
}
