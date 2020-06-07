<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use GraphQL\Error\FormattedError;
use GraphQL\Error\Debug;

class TestController extends Controller
{
	public $layout = 'layouts.backend';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // deny all users
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)["id"=>"custom","action"=>(object)["id"=>"developer"]])',
			),
			array('allow',  // deny all users
				'actions' => array('helloWorld', 'event', 'yiiEvent'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionYiiEvent()
	{
		$tmps = Event::model()->findAllByAttributes(
			array(
				'is_active' => 1,
			),
			array(
				'order' => 'date_started desc'
			)
		);

		$result = array();
		foreach ($tmps as $tmp) {
			$result[] = $tmp->toApi();
		}

		print_r($result);
	}

	public function actionEvent()
	{
		$debug = false;
		/*set_error_handler(function ($severity, $message, $file, $line) use (&$phpErrors) {
			throw new ErrorException($message, 0, $severity, $file, $line);
		});
		$debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;*/

		try {
			if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
				$raw = file_get_contents('php://input') ?: '';
				$data = json_decode($raw, true) ?: [];
			} else {
				$data = $_REQUEST;
			}

			$data += ['query' => null, 'variables' => null];

			if (null === $data['query']) {
				$data['query'] = '{hello}';
			}

			$schema = new Schema([
				'query' => Types::query()
			]);

			$result = GraphQL::executeQuery(
				$schema,
				$data['query'],
				null,
				null,
				(array) $data['variables']
			);
			$output = $result->toArray($debug);
		} catch (\Exception $e) {
			$output = [
				'error' => [
					'message' => $e->getMessage()
				]
			];
		}
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($output);
	}

	/*
	query:
		query {echo(message: "Hello World")}
	*/
	public function actionHelloWorld()
	{
		try {
			$queryType = new ObjectType([
				'name' => 'Query',
				'fields' => [
					'echo' => [
						'type' => Type::string(),
						'args' => [
							'message' => ['type' => Type::string()],
						],
						'resolve' => function ($rootValue, $args) {
							return $rootValue['prefix'] . $args['message'];
						}
					],
				],
			]);

			$mutationType = new ObjectType([
				'name' => 'Calc',
				'fields' => [
					'sum' => [
						'type' => Type::int(),
						'args' => [
							'x' => ['type' => Type::int()],
							'y' => ['type' => Type::int()],
						],
						'resolve' => function ($calc, $args) {
							return $args['x'] + $args['y'];
						},
					],
				],
			]);

			// See docs on schema options:
			// http://webonyx.github.io/graphql-php/type-system/schema/#configuration-options
			$schema = new Schema([
				'query' => $queryType,
				'mutation' => $mutationType,
			]);

			$rawInput = file_get_contents('php://input');
			$input = json_decode($rawInput, true);
			$query = $input['query'];
			$variableValues = isset($input['variables']) ? $input['variables'] : null;

			$rootValue = ['prefix' => 'You said: '];
			$result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
			$output = $result->toArray();
		} catch (\Exception $e) {
			$output = [
				'error' => [
					'message' => $e->getMessage()
				]
			];
		}
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($output);
	}

	public function actionOS4GrowthOrganizationBehavior()
	{
		$organization = new Organization;
		var_dump($organization->shoutOS4Growth());
	}

	public function actionIndex()
	{
		//if you want to use reflection
		$reflection = new ReflectionClass('TestController');
		$methods = $reflection->getMethods();
		$actions = array();
		foreach ($methods as $method) {
			if (substr($method->name, 0, 6) == 'action' && $method->name != 'actionIndex' && $method->name != 'actions') {
				$methodName4Url = lcfirst(substr($method->name, 6));
				$actions[] = $methodName4Url;
			}
		}

		Yii::t('test', 'Test actions');

		$this->render('index', array('actions' => $actions));
	}
}
