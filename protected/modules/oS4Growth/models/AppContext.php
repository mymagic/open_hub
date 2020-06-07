<?php


/**
 * Instance available in all GraphQL resolvers as 3rd argument
 */
class AppContext
{
	/**
	 * @var string
	 */
	public $rootUrl;

	/**
	 * @var User
	 */
	public $viewer;

	/**
	 * @var \mixed
	 */
	public $request;
}
