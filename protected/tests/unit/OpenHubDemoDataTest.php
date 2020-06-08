<?php

class OpenHubDemoDataTest extends CDbTestCase
{
	protected function setUp()
	{
		HubOpenHub::loadDemoData();
		parent::setUp();
	}

	public function testPersona()
	{
		// aspiring
		$personaAspiring = Persona::model()->findByAttributes(array('slug' => 'student'));
		$this->assertTrue($personaAspiring instanceof Persona);
		$this->assertEquals('Aspiring Entrepreneurs', $personaAspiring->title);
		$this->assertEquals('Aspiring Entrepreneurs', $personaAspiring->title_en);
		$this->assertEquals('1', $personaAspiring->is_active);

		// startup
		$personaStartup = Persona::model()->findByAttributes(array('slug' => 'startups'));
		$this->assertTrue($personaStartup instanceof Persona);
		$this->assertEquals('Startups', $personaStartup->title);
		$this->assertEquals('Startups', $personaStartup->title_en);
		$this->assertEquals('1', $personaStartup->is_active);

		// se
		$personaSe = Persona::model()->findByAttributes(array('slug' => 'se'));
		$this->assertTrue($personaSe instanceof Persona);
		$this->assertEquals('Social Enterprise', $personaSe->title);
		$this->assertEquals('Social Enterprise', $personaSe->title_en);
		$this->assertEquals('1', $personaSe->is_active);

		// corporate
		$personaCorperate = Persona::model()->findByAttributes(array('slug' => 'corporate'));
		$this->assertTrue($personaCorperate instanceof Persona);
		$this->assertEquals('Corporate', $personaCorperate->title);
		$this->assertEquals('Corporate', $personaCorperate->title_en);
		$this->assertEquals('1', $personaCorperate->is_active);

		// government
		$personaGovernment = Persona::model()->findByAttributes(array('slug' => 'government'));
		$this->assertTrue($personaGovernment instanceof Persona);
		$this->assertEquals('Government Ministry / Agencies', $personaGovernment->title);
		$this->assertEquals('Government Ministry / Agencies', $personaGovernment->title_en);
		$this->assertEquals('1', $personaGovernment->is_active);

		// investor
		$personaInvestor = Persona::model()->findByAttributes(array('slug' => 'investor'));
		$this->assertTrue($personaInvestor instanceof Persona);
		$this->assertEquals('Investor / VC', $personaInvestor->title);
		$this->assertEquals('Investor / VC', $personaInvestor->title_en);
		$this->assertEquals('1', $personaInvestor->is_active);
	}

	public function testPiedPiper()
	{
		$personaStartup = Persona::model()->findByAttributes(array('slug' => 'startups'));

		$piedPiper = HubOrganization::getOrganizationByTitle('Pied Piper');
		$this->assertTrue($piedPiper instanceof Organization);
		$this->assertEquals('http://www.piedpiper.com/', $piedPiper->url_website);
		$this->assertEquals('hello@piedpiper.com', $piedPiper->email_contact);
		$this->assertEquals('2014', $piedPiper->year_founded);
		$this->assertEquals('2 New Montgomery St, San Francisco, CA 94105, United States', $piedPiper->full_address);
		$this->assertTrue($piedPiper->hasPersona($personaStartup->id));
		$this->assertEquals('compression, saas', $piedPiper->tag_backend);

		// organization2email
		$this->assertTrue($piedPiper->hasUserEmail('richard@piedpiper.com', 'approve'));
		$this->assertTrue($piedPiper->hasUserEmail('dinesh@piedpiper.com', 'approve'));
		$this->assertTrue($piedPiper->hasUserEmail('erlich@piedpiper.com', 'reject'));
		$this->assertTrue($piedPiper->hasUserEmail('gilfoyle@piedpiper.com', 'pending'));
		$this->assertTrue($piedPiper->hasUserEmail('jared@piedpiper.com', 'pending'));

		// richard
		$richard = HubIndividual::getIndividualByFullname('Richard Hendricks');
		$this->assertTrue($richard instanceof Individual);
		$this->assertEquals('male', $richard->gender);
		$this->assertEquals('US', $richard->country_code);
		$this->assertTrue($richard->hasUserEmail('richard@piedpiper.com'));
		$this->assertTrue($piedPiper->hasIndividualOrganization($richard->id, 'founder'));

		// jared
		$jared = HubIndividual::getIndividualByFullname('Jared Donald Dunn');
		$this->assertTrue($jared instanceof Individual);
		$this->assertEquals('male', $jared->gender);
		$this->assertEquals('US', $jared->country_code);
		$this->assertTrue($jared->hasUserEmail('jared@piedpiper.com'));
		$this->assertTrue($piedPiper->hasIndividualOrganization($jared->id, 'cofounder'));

		// dinesh
		// dinesh country code is not set
		$dinesh = HubIndividual::getIndividualByFullname('Dinesh Chugtai');
		$this->assertTrue($dinesh instanceof Individual);
		$this->assertEquals('male', $dinesh->gender);
		$this->assertTrue($dinesh->hasUserEmail('dinesh@piedpiper.com'));
		$this->assertTrue($piedPiper->hasIndividualOrganization($dinesh->id, 'cofounder'));

		// gilfoyle
		// gilfoyle is not linked to the organization
		$gilfoyle = HubIndividual::getIndividualByFullname('Bertram Gilfoyle');
		$this->assertTrue($gilfoyle instanceof Individual);
		$this->assertEquals('male', $gilfoyle->gender);
		$this->assertEquals('US', $gilfoyle->country_code);
		$this->assertTrue($gilfoyle->hasUserEmail('gilfoyle@piedpiper.com'));

		// erlich
		$erlich = HubIndividual::getIndividualByFullname('Erlich Bachman');
		$this->assertTrue($erlich instanceof Individual);
		$this->assertEquals('male', $erlich->gender);
		$this->assertEquals('US', $erlich->country_code);
		$this->assertTrue($erlich->hasUserEmail('erlich@piedpiper.com'));
		$this->assertTrue($piedPiper->hasIndividualOrganization($erlich->id, 'founder'));

		// anton
		// anton is not linked to the organization
		$anton = HubIndividual::getIndividualByFullname('Son of Anton');
		$this->assertTrue($anton instanceof Individual);
		$this->assertEquals('US', $anton->country_code);
		$this->assertTrue($anton->hasUserEmail('gilfoyle@piedpiper.com'));

		// product
		// funding
		// revenue
	}
}
