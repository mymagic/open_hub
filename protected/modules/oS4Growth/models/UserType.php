<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class UserType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'User',
			'description' => 'Our system user',
			'fields' => function () {
				return [
					'id' => Types::id(),
					'username' => Types::email(),
				];
			},
			'interfaces' => [
				Types::node()
			]
		];
		parent::__construct($config);
	}
}
