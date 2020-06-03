<?php

class ImpactTest extends CDbTestCase
{
	public $fixtures = array(
		'impact' => 'Impact',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$impact1 = $this->impact('impact1');
		$this->assertTrue($impact1 instanceof Impact);
		$this->assertEquals('Access to education', $impact1->title);
	}

	public function testCreate()
	{
		$impact = new Impact;
		$impact->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Impact',
				'is_active' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($impact->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Impact::model()->findByPk($impact->id);
		$this->assertTrue($retrievedRecord instanceof Impact);
		$this->assertEquals('Test Impact', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$impact = $this->impact('impact1');
		$updatedImpactTitle = 'Test Impact';
		$impact->title = $updatedImpactTitle;
		$this->assertTrue($impact->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Impact::model()->findByPk($impact->id);
		$this->assertTrue($updatedRecord instanceof Impact);
		$this->assertEquals($updatedImpactTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$impact = $this->impact('impact1');
		$savedId = $impact->id;
		$this->assertTrue($impact->delete());
		$deletedRecord = Impact::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
