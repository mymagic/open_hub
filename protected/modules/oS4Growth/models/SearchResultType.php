<?php

use GraphQL\Type\Definition\UnionType;

class SearchResultType extends UnionType
{
	public function __construct()
	{
		$config = [
			'name' => 'SearchResultType',
			'types' => function () {
				return [
					Types::event(),
					Types::user()
				];
			},
			'resolveType' => function ($value) {
				if ($value instanceof Event) {
					return Types::event();
				} elseif ($value instanceof User) {
					return Types::user();
				}
			}
		];
		parent::__construct($config);
	}
}
