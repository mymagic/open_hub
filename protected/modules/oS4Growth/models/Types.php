<?php

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\Type;

/**
 * Acts as a registry and factory for your types.
 *
 * As simplistic as possible for the sake of clarity of this example.
 * Your own may be more dynamic (or even code-generated).
 */
class Types
{
	// Object types:
	private static $user;
	private static $event;
	private static $query;

	/**
	 * @return UserType
	 */
	public static function user()
	{
		return self::$user ?: (self::$user = new UserType());
	}

	/**
	 * @return EventType
	 */
	public static function event()
	{
		return self::$event ?: (self::$event = new EventType());
	}

	/**
	 * @return QueryType
	 */
	public static function query()
	{
		return self::$query ?: (self::$query = new QueryType());
	}

	// Interface types
	private static $node;

	/**
	 * @return NodeType
	 */
	public static function node()
	{
		return self::$node ?: (self::$node = new NodeType());
	}

	// Unions types:
	private static $mention;

	/**
	 * @return SearchResultType
	 */
	public static function mention()
	{
		return self::$mention ?: (self::$mention = new SearchResultType());
	}

	// Enum types
	private static $contentFormatEnum;

	/**
	 * @return ContentFormatEnum
	 */
	public static function contentFormatEnum()
	{
		return self::$contentFormatEnum ?: (self::$contentFormatEnum = new ContentFormatEnum());
	}

	// Custom Scalar types:
	private static $urlType;
	private static $emailType;

	public static function email()
	{
		return self::$emailType ?: (self::$emailType = EmailType::create());
	}

	/**
	 * @return UrlType
	 */
	public static function url()
	{
		return self::$urlType ?: (self::$urlType = new UrlType());
	}

	/**
	 * @param $name
	 * @param null $objectKey
	 * @return array
	 */
	public static function htmlField($name, $objectKey = null)
	{
		return HtmlField::build($name, $objectKey);
	}

	// Let's add internal types as well for consistent experience

	public static function boolean()
	{
		return Type::boolean();
	}

	/**
	 * @return \GraphQL\Type\Definition\FloatType
	 */
	public static function float()
	{
		return Type::float();
	}

	/**
	 * @return \GraphQL\Type\Definition\IDType
	 */
	public static function id()
	{
		return Type::id();
	}

	/**
	 * @return \GraphQL\Type\Definition\IntType
	 */
	public static function int()
	{
		return Type::int();
	}

	/**
	 * @return \GraphQL\Type\Definition\StringType
	 */
	public static function string()
	{
		return Type::string();
	}

	/**
	 * @param Type $type
	 * @return ListOfType
	 */
	public static function listOf($type)
	{
		return new ListOfType($type);
	}

	/**
	 * @param Type $type
	 * @return NonNull
	 */
	public static function nonNull($type)
	{
		return new NonNull($type);
	}
}
