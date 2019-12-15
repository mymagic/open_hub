<?php

class Cluster extends ClusterBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'ordering' => $this->ordering,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
		);
			
		return $return;
	}
}
