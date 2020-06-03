<?php

class YeeTest extends CTestCase
{
	public function testYeeBaseGetVersion()
	{
		$this->assertNotEmpty(YeeBase::getVersion());
	}
}
