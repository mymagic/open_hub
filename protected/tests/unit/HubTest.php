<?php

class HubTest extends CTestCase
{
	public function testSimpleSum()
	{
		$var1 = 1;
		$var2 = 2;
		$this->assertEquals(3, $var1 + $var2);
	}
}
