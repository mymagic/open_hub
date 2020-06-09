<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'Query',
			'fields' => [
				'user' => [
					'type' => Types::user(),
					'description' => 'Returns user by id (in range of 1-5)',
					'args' => [
						'id' => Types::nonNull(Types::id())
					]
				],
				'viewer' => [
					'type' => Types::user(),
					'description' => 'Represents currently logged-in user (for the sake of example - simply returns user with id == 1)'
				],
				'events' => [
					'type' => Types::listOf(Types::event()),
					'description' => 'Returns subset of stories posted for this blog',
					'args' => [
						'after' => [
							'type' => Types::id(),
							'description' => 'Fetch stories listed after the story with this ID'
						],
						'limit' => [
							'type' => Types::int(),
							'description' => 'Number of stories to be returned',
							'defaultValue' => 10
						]
					]
				],
				'lastStoryPosted' => [
					'type' => Types::event(),
					'description' => 'Returns last story posted for this blog'
				],
				'deprecatedField' => [
					'type' => Types::string(),
					'deprecationReason' => 'This field is deprecated!'
				],
				'fieldWithException' => [
					'type' => Types::string(),
					'resolve' => function () {
						throw new \Exception('Exception message thrown in field resolver');
					}
				],
				'hello' => Type::string()
			],
			'resolveField' => function ($rootValue, $args, $context, ResolveInfo $info) {
				return $this->{$info->fieldName}($rootValue, $args, $context, $info);
			}
		];
		parent::__construct($config);
	}

	public function user($rootValue, $args)
	{
		return User::model()->findByPk($args['id']);
	}

	public function viewer($rootValue, $args, AppContext $context)
	{
		return $context->viewer;
	}

	public function events($rootValue, $args)
	{
		$args += ['after' => null];

		// after id
		if (!empty($args['after'])) {
			$tmps = Event::model()->findAllByAttributes(
				array(
					'is_active' => 1,
				),
				array(
					'order' => 'date_started desc',
					'offset' => $args['after'],
					'limit' => 100
				)
			);
		} else {
			$tmps = Event::model()->findAllByAttributes(
				array(
					'is_active' => 1,
				),
				array(
					'order' => 'date_started desc',
					'limit' => 100
				)
			);
		}

		$result = array();
		$params['config']['mode'] = 'public';
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi($params);
		}

		return $result;
	}

	public function lastStoryPosted()
	{
		return null;
	}

	public function hello()
	{
		return 'Your graphql-php endpoint is ready! Use GraphiQL to browse API';
	}

	public function deprecatedField()
	{
		return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
	}
}
