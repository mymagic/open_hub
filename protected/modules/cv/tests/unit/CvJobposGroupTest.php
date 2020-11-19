<?php

class CvJobposGroupTest extends CDbTestCase
{
	private $basePathOld = null;

	public $fixtures = array(
		'cv_jobpos_group' => 'CvJobposGroup',
	);

	protected function setUp()
	{
		$fixturePath = Yii::getPathOfAlias('application.modules.cv.tests.fixtures');
		if (is_dir($fixturePath)) {
			$this->basePathOld = $this->getFixtureManager()->basePath;
			$this->getFixtureManager()->basePath = $fixturePath;
		}
		$this->getFixtureManager()->prepare();

		parent::setUp();
	}

	protected function tearDown()
	{
		$this->getFixtureManager()->truncateTable('cv_jobpos_group');

		parent::tearDown();
		if (null !== $this->basePathOld) {
			$this->getFixtureManager()->basePath = $this->basePathOld;
		}
	}

	public function testRead()
	{
		$jobposGroup1 = $this->cv_jobpos_group('softwareDevelopment');
		$this->assertTrue($jobposGroup1 instanceof CvJobposGroup);
		$this->assertEquals('Software Development', $jobposGroup1->title);
	}

	public function testCreate()
	{
		$jobposGroup = new CvJobposGroup;
		$jobposGroup->setAttributes(
			array(
				'title' => 'Test Job Position Group',
				'is_active' => '1',
				'ordering' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($jobposGroup->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = CvJobposGroup::model()->findByPk($jobposGroup->id);
		$this->assertTrue($retrievedRecord instanceof CvJobposGroup);
		$this->assertEquals('Test Job Position Group', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$jobposGroup = $this->cv_jobpos_group('softwareDevelopment');
		$updatedTitle = 'Test Software Development';
		$jobposGroup->title = $updatedTitle;
		$this->assertTrue($jobposGroup->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = CvJobposGroup::model()->findByPk($jobposGroup->id);
		$this->assertTrue($updatedRecord instanceof CvJobposGroup);
		$this->assertEquals($updatedTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$jobposGroup = $this->cv_jobpos_group('softwareDevelopment');
		$savedId = $jobposGroup->id;
		$this->assertTrue($jobposGroup->delete());
		$deletedRecord = CvJobposGroup::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
