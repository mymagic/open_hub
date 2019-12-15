<?php

class Tag2Subject extends Tag2SubjectBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function relations()
	{
		return array(
			'subject'  => array( self::BELONGS_TO, 'Subject', 'subject_id' ),
			'tag'   => array( self::BELONGS_TO, 'Tag', 'tag_id' ),
		);
	}
	
}
