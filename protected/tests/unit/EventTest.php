<?php

class EventTest extends CDbTestCase
{
	public $fixtures = array(
		'event' => 'Event',
		'event_group' => 'EventGroup',
	);

	protected function setUp()
	{
		parent::setUp();
	}
}
