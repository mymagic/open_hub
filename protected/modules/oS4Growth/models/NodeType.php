<?php


use GraphQL\Type\Definition\InterfaceType;

class NodeType extends InterfaceType
{
	public function __construct()
	{
		$config = [
			'name' => 'Node',
			'fields' => [
				'id' => Types::id()
			],
			'resolveType' => [$this, 'resolveNodeType']
		];
		parent::__construct($config);
	}

	public function resolveNodeType($object)
	{
		if ($object instanceof User) {
			return Types::user();
		} elseif ($object instanceof Event) {
			return Types::event();
		}
	}
}
