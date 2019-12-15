<?php

class Skillset2Program extends Skillset2ProgramBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function relations()
	{
		return array(
			'program'  => array( self::BELONGS_TO, 'Program', 'program_id' ),
			'skillset'   => array( self::BELONGS_TO, 'Skillset', 'skillset_id' ),
		);
	
	}
}
