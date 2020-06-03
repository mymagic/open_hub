<?php

class ClusterTest extends CDbTestCase
{
	public $fixtures = array(
		'cluster' => 'Cluster',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$cluster1 = $this->cluster('finTech');
		$this->assertTrue($cluster1 instanceof Cluster);
		$this->assertEquals('Fintech', $cluster1->title);
	}

	public function testCreate()
	{
		$cluster = new Cluster;
		$cluster->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Cluster',
				'text_short_description' => 'Just a Test Cluster',
				'is_active' => '1',
				'ordering' => '99',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($cluster->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Cluster::model()->findByPk($cluster->id);
		$this->assertTrue($retrievedRecord instanceof Cluster);
		$this->assertEquals('Test Cluster', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$cluster = $this->cluster('finTech');
		$updatedClusterTitle = 'Test Fintech';
		$cluster->title = $updatedClusterTitle;
		$this->assertTrue($cluster->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Cluster::model()->findByPk($cluster->id);
		$this->assertTrue($updatedRecord instanceof Cluster);
		$this->assertEquals($updatedClusterTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$cluster = $this->cluster('finTech');
		$savedId = $cluster->id;
		$this->assertTrue($cluster->delete());
		$deletedRecord = Cluster::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
