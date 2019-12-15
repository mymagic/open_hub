<?php

class CaptchaAction extends CCaptchaAction
{
	public $numberOnly;
	
	protected function generateVerifyCode()
	{
		if($this->minLength > $this->maxLength)
			$this->maxLength = $this->minLength;
		if($this->minLength < 3)
			$this->minLength = 3;
		if($this->maxLength > 20)
			$this->maxLength = 20;
		$length = mt_rand($this->minLength,$this->maxLength);
		
		$code = '';
		if(!$this->numberOnly)
		{
			$letters = 'bcdfghjklmnpqrstvwxyz';
			$vowels = 'aeiou';
			
			for($i = 0; $i < $length; ++$i)
			{
				if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
					$code.=$vowels[mt_rand(0,4)];
				else
					$code.=$letters[mt_rand(0,20)];
			}
		}
		else
		{
			$letters = '1234567890';
			
			for($i = 0; $i < $length; ++$i)
			{
				$code.=$letters[mt_rand(0,9)];
			}
		}

		return $code;
	}
}