<?php

class SdgTest extends CDbTestCase
{
	public $fixtures = array(
		'sdg' => 'Sdg',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$sdg1 = $this->sdg('sdg1');
		$this->assertTrue($sdg1 instanceof Sdg);
		$this->assertEquals('No Poverty', $sdg1->title);
	}

	public function testCreate()
	{
		$sdg = new Sdg;
		$sdg->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Sdg',
				'title_en' => 'Test Sdg (EN)',
				'title_ms' => 'Test Sdg (MS)',
				'text_short_description' => 'This is a test Sdg',
				'text_short_description_en' => 'This is a test Sdg (EN)',
				'text_short_description_ms' => 'This is a test Sdg (MS)',
				'is_active' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($sdg->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Sdg::model()->findByPk($sdg->id);
		$this->assertTrue($retrievedRecord instanceof Sdg);
		$this->assertEquals('Test Sdg', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$sdg = $this->sdg('sdg1');
		$updatedSdgTitle = 'Test No Poverty';
		$sdg->title = $updatedSdgTitle;
		$this->assertTrue($sdg->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Sdg::model()->findByPk($sdg->id);
		$this->assertTrue($updatedRecord instanceof Sdg);
		$this->assertEquals($updatedSdgTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$sdg = $this->sdg('sdg1');
		$savedId = $sdg->id;
		$this->assertTrue($sdg->delete());
		$deletedRecord = Sdg::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
