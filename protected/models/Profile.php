<?php 
class Profile extends ProfileBase
{
	public $fullAddress;
	
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'country' => array(self::HAS_ONE, 'Country', array('code'=>'country_code')),
		);
	}
	
	public function getFullAddress()
	{
		$this->fullAddress = "";
		
		if(!empty($this->address_line1))
		{
			$this->fullAddress .= $this->address_line1;
			if(substr(trim($this->address_line1), -1) != ","){$this->fullAddress .=  ", ";}
		}
		
		if(!empty($this->address_line2))
		{
			$this->fullAddress .= $this->address_line2;
			if(substr(trim($this->address_line2), -1) != ","){$this->fullAddress .=  ", ";}
		}
		$this->fullAddress .= "\n";
		
		if(!empty($this->town))
		{
			$this->fullAddress .= $this->town;
			if(substr(trim($this->town), -1) != ","){$this->fullAddress .=  ", ";}
		}
		
		if(!empty($this->state))
		{
			$this->fullAddress .= $this->state;
			if(substr(trim($this->state), -1) != ","){$this->fullAddress .=  ", ";}
		}
		
		if(!empty($this->postcode))
		{
			$this->fullAddress .= $this->postcode;
			if(substr(trim($this->postcode), -1) != ","){$this->fullAddress .=  ", ";}
		}
		
		$this->fullAddress .= $this->country->printable_name;
		
		return $this->fullAddress;
	}

	public function figureFirstName()
	{
		$parts = explode(" ", $this->full_name);
		$lastname = array_pop($parts);
		$firstname = implode(" ", $parts);
		return $firstname;
	}
	public function figureLastName()
	{
		$parts = explode(" ", $this->full_name);
		$lastname = array_pop($parts);
		$firstname = implode(" ", $parts);
		return $lastname;
	}
}
?>