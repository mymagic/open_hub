<?php

class StartupStageTest extends CDbTestCase
{
	public $fixtures = array(
		'startup_stage' => 'StartupStage',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$startupStage1 = $this->startup_stage('startupStage1');
		$this->assertTrue($startupStage1 instanceof StartupStage);
		$this->assertEquals('Discovery', $startupStage1->title);
	}

	public function testCreate()
	{
		$startupStage = new StartupStage;
		$startupStage->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Startup Stage',
				'title_en' => 'Test Startup Stage (EN)',
				'title_ms' => 'Test Startup Stage (MS)',
				'text_short_description' => 'This is a test startup stages and it should be the last of all stages',
				'text_short_description_en' => 'This is a test startup stages and it should be the last of all stages (EN)',
				'text_short_description_ms' => 'This is a test startup stages and it should be the last of all stages (MS)',
				'ordering' => '7',
				'is_active' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($startupStage->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = StartupStage::model()->findByPk($startupStage->id);
		$this->assertTrue($retrievedRecord instanceof StartupStage);
		$this->assertEquals('Test Startup Stage', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$startupStage = $this->startup_stage('startupStage1');
		$updatedStartupStageTitle = 'Test Discovery';
		$startupStage->title = $updatedStartupStageTitle;
		$this->assertTrue($startupStage->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = StartupStage::model()->findByPk($startupStage->id);
		$this->assertTrue($updatedRecord instanceof StartupStage);
		$this->assertEquals($updatedStartupStageTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$startupStage = $this->startup_stage('startupStage1');
		$savedId = $startupStage->id;
		$this->assertTrue($startupStage->delete());
		$deletedRecord = StartupStage::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
