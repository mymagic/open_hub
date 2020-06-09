<?php


use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class EventType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'Event',
			'fields' => function () {
				return [
					'id' => Types::id(),
					'title' => Types::string(),
					'fDateStarted' => Types::string(),
					'fDateEnded' => Types::string(),
					'at' => Types::string(),
					'urlWebsite' => Types::string(),
					//Types::htmlField('textShortDesc'),
					'isActive' => Types::boolean(),
				];
			},
			'interfaces' => [
				Types::node()
			]
		];
		parent::__construct($config);
	}
}
