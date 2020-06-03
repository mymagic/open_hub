<?php

class JunkTest extends CDbTestCase
{
	public $fixtures = array(
		'junk' => 'Junk',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$junk1 = $this->junk('junk1');
		$this->assertTrue($junk1 instanceof Junk);
		$this->assertEquals('unittest-1', $junk1->code);
	}

	public function testRenderContent()
	{
		$junk1 = $this->junk('junk1');
		$this->assertNotNull($junk1->renderContent());
	}

	public function testCreate()
	{
		$junk = new Junk;
		$code = 'unittest-adhoc-1';
		$junk->setAttributes(
			array(
				'code' => $code,
				'content' => json_encode(array('Happy' => 'Birthday')),
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($junk->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Junk::model()->findByPk($junk->id);
		$this->assertTrue($retrievedRecord instanceof Junk);
		$this->assertEquals($code, $retrievedRecord->code);
	}

	public function testUpdate()
	{
		$junk = $this->junk('junk2');
		$updatedJunkContent = json_encode(array('foo' => 'bar bar black sheep'));
		$junk->content = $updatedJunkContent;
		$this->assertTrue($junk->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Junk::model()->findByPk($junk->id);
		$this->assertTrue($updatedRecord instanceof Junk);
		$this->assertEquals($updatedJunkContent, $updatedRecord->content);
	}

	public function testDelete()
	{
		$junk = $this->junk('junk2');
		$savedId = $junk->id;
		$this->assertTrue($junk->delete());
		$deletedRecord = Junk::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}

	public function testCreateNew()
	{
		$code = 'unittest-adhoc-2';
		$junk = Junk::createNew($code, json_encode(array('Green' => 'Lantern')));

		$retrievedRecord = Junk::model()->findByPk($junk->id);
		$this->assertTrue($retrievedRecord instanceof Junk);
		$this->assertEquals($code, $retrievedRecord->code);
	}
}
