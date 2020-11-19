<?php

class CvTest extends CTestCase
{
	public $fixtures = array(
		//'startup_stage' => 'StartupStage',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testHelloWorld()
	{
		$var = 'Hello World';
		$this->assertEquals('Hello World', $var);
	}
}
