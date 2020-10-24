<?php

class CvJobposTest extends CDbTestCase
{
	private $basePathOld = null;

	public $fixtures = array(
		'cv_jobpos_group' => 'CvJobposGroup',
		'cv_jobpos' => 'CvJobpos',
		'event' => 'Event',
		'event_registration' => 'EventRegistration',
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
		$this->getFixtureManager()->truncateTable('event');
		$this->getFixtureManager()->truncateTable('event_registration');
		$this->getFixtureManager()->truncateTable('cv_portfolio');
		$this->getFixtureManager()->truncateTable('cv_jobpos');
		$this->getFixtureManager()->truncateTable('cv_jobpos_group');

		parent::tearDown();
		if (null !== $this->basePathOld) {
			$this->getFixtureManager()->basePath = $this->basePathOld;
		}
	}

	public function testEventRegistration()
	{
		$user = User::model()->findByPk('1');
		$event999 = Event::model()->findByPk('999');
		$event998 = Event::model()->findByPk('998');

		// check event999 and event998 has registration to this user
		$this->assertTrue($event999 instanceof Event);
		$this->assertEquals('Test Event 1', $event999->title);
		$this->assertTrue($event999->hasEventRegistration($user->username));

		$this->assertTrue($event998 instanceof Event);
		$this->assertEquals('Test Event 2', $event998->title);

		$registrations = $event999->getEventRegistrations($user->username);
		$this->assertCount(1, $registrations);
	}

	public function testCreate()
	{
		$user = User::model()->findByPk('1');
		$jobpos = CvJobpos::model()->findByPk('1');

		$portfolio = new CvPortfolio;
		$portfolio->setAttributes(
			array(
				'display_name' => 'Foo Bar',
				'user_id' => $user->id,
				'jobpos_id' => $jobpos->id,
				'text_oneliner' => 'Hello World!',
				'text_short_description' => 'Bla Bla Bla...',
				'organization_name' => 'MaGIC',
				'location' => 'Cyberjaya',
				'text_address_residential' => 'MaGIC, 3730, Persiaran Apec, Cyberjaya, 63000 Cyberjaya, Selangor, Malaysia',
				'url_facebook' => 'https://www.facebook.com/foobar',
				'is_looking_cofounder' => '1',
				'is_active' => '1',
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$portfolio->resetAddressParts();
		$this->assertTrue($portfolio->save(false));

		// add custom experience
		$experienceStudyMMU = new CvExperience;
		$experienceStudyMMU->setAttributes(
			array(
				'title' => 'Bachelor Degree of Software Engineering & Game Design',
				'cv_portfolio_id' => $portfolio->id,
				'organization_name' => 'Multimedia University',
				'location' => 'Multimedia University, Cyberjaya',
				'full_address' => 'Persiaran Multimedia, 63100 Cyberjaya, Selangor, Malaysia',
				'year_start' => '2001',
				'year_end' => '2005',
				'genre' => 'study',
				'text_short_description' => 'I studied Software Engineering & Game Design during arguably, one of the most seminal moments of the game industry.',
				'is_active' => 1,
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$experienceStudyMMU->resetAddressParts();
		$this->assertTrue($experienceStudyMMU->save(false));

		$experienceWorkMMU = new CvExperience;
		$experienceWorkMMU->setAttributes(
			array(
				'title' => 'Research Officer',
				'cv_portfolio_id' => $portfolio->id,
				'organization_name' => 'Multimedia University',
				'location' => 'Multimedia University, Cyberjaya',
				'full_address' => 'Persiaran Multimedia, 63100 Cyberjaya, Selangor, Malaysia',
				'year_start' => '2005',
				'month_start' => '9',
				'year_end' => '2006',
				'month_end' => '1',
				'genre' => 'job',
				'text_short_description' => 'I was working as a contract base Research Officer, and implemented a GUI Desktop application alone as a module. It aids teacher to create assessment easily.',
				'is_active' => 1,
				'date_added' => time(),
				'date_modified' => time(),
			)
		);
		$experienceWorkMMU->resetAddressParts();
		$this->assertTrue($experienceWorkMMU->save(false));

		// READ back the newly created Project to ensure the creation worked
		$retrievedRecord = CvPortfolio::model()->findByPk($portfolio->id);
		$this->assertTrue($retrievedRecord instanceof CvPortfolio);
		$this->assertEquals('Foo Bar', $retrievedRecord->display_name);
		$this->assertEquals('public', $retrievedRecord->visibility);
		$this->assertEquals('https://www.facebook.com/foobar', $retrievedRecord->url_facebook);
		$this->assertEquals($retrievedRecord->getDefaultImageAvatar(), $retrievedRecord->image_avatar);

		// check user
		$this->assertEquals($user->username, $retrievedRecord->user->username);
		$this->assertTrue($user->hasCvPortfolio());
		$this->assertEquals('Foo Bar', $user->getCvPortfolio()->display_name);

		// check job position
		$this->assertEquals($jobpos->title, $retrievedRecord->cvJobpos->title);

		// check registered event
		$registeredPrograms = $portfolio->getRegisteredPrograms();
		$this->assertCount(2, $registeredPrograms);
		$this->assertEquals('Test Event 2', $registeredPrograms[0]['title']);
		$this->assertEquals('Test Event 1', $registeredPrograms[1]['title']);

		// check attended event
		$attendedPrograms = $portfolio->getAttendedPrograms();
		$this->assertCount(1, $attendedPrograms);
		$this->assertEquals('Test Event 1', $attendedPrograms[0]['title']);

		// check composed experience
		$composedExperiences = $portfolio->getComposedExperiences();
	}
}
