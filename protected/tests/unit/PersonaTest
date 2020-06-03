<?php

class PersonaTest extends CDbTestCase
{
	public $fixtures = array(
		'persona' => 'Persona',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$persona1 = $this->persona('persona1');
		$this->assertTrue($persona1 instanceof Persona);
		$this->assertEquals('Aspiring Entrepreneurs', $persona1->title);
	}

	public function testCreate()
	{
		$persona = new Persona;
		$persona->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Persona',
				'title_en' => 'Test Persona (EN)',
				'title_ms' => 'Test Persona (MS)',
				'text_short_description' => 'This is a test Persona',
				'text_short_description_en' => 'This is a test Persona (EN)',
				'text_short_description_ms' => 'This is a test Persona (MS)',
				'is_active' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($persona->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Persona::model()->findByPk($persona->id);
		$this->assertTrue($retrievedRecord instanceof Persona);
		$this->assertEquals('Test Persona', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$persona = $this->persona('persona1');
		$updatedPersonaTitle = 'Test Aspiring Entrepreneurs';
		$persona->title = $updatedPersonaTitle;
		$this->assertTrue($persona->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Persona::model()->findByPk($persona->id);
		$this->assertTrue($updatedRecord instanceof Persona);
		$this->assertEquals($updatedPersonaTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$persona = $this->persona('persona1');
		$savedId = $persona->id;
		$this->assertTrue($persona->delete());
		$deletedRecord = Persona::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
