<?php

class IndustryTest extends CDbTestCase
{
	public $fixtures = array(
		'industry' => 'Industry',
		'industry_keyword' => 'IndustryKeyword',
	);

	protected function setUp()
	{
		parent::setUp();
	}

	public function testRead()
	{
		$industry = $this->industry('industry1');
		$this->assertTrue($industry instanceof Industry);
		$this->assertEquals('Agriculture', $industry->title);
	}

	public function testRenderIndustryKeywords()
	{
		$industry = $this->industry('industry1');
		$this->assertEquals('Agrotechnology', $industry->renderIndustryKeywords());

		$industry2 = $this->industry('industry2');
		$this->assertEquals('Creative & Arts, Design', $industry2->renderIndustryKeywords());
	}

	public function testSearchByKeyword()
	{
		$industry = Industry::searchByKeyword('Agrotechnology');
		$this->assertTrue($industry instanceof Industry);
		$this->assertEquals('Agriculture', $industry->title);
	}

	public function testCreate()
	{
		$industry = new Industry;
		$industry->setAttributes(
			array(
				'slug' => 'test',
				'title' => 'Test Industry',
				'title_en' => 'Test Industry',
				'title_ms' => 'Test Industry',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$this->assertTrue($industry->save(false));
		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = Industry::model()->findByPk($industry->id);
		$this->assertTrue($retrievedRecord instanceof Industry);
		$this->assertEquals('Test Industry', $retrievedRecord->title);
	}

	public function testUpdate()
	{
		$industry = $this->industry('industry1');
		$updatedIndustryTitle = 'Test Agriculture';
		$industry->title = $updatedIndustryTitle;
		$this->assertTrue($industry->save(false));

		//read back the record again to ensure the update worked
		$updatedRecord = Industry::model()->findByPk($industry->id);
		$this->assertTrue($updatedRecord instanceof Industry);
		$this->assertEquals($updatedIndustryTitle, $updatedRecord->title);
	}

	public function testDelete()
	{
		$industry = $this->industry('industry1');
		$savedId = $industry->id;
		$this->assertTrue($industry->delete());
		$deletedRecord = Industry::model()->findByPk($savedId);
		$this->assertEquals(null, $deletedRecord);
	}
}
