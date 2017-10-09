<?php 

use Respect\Validation\Validator as v;

session_start();

require '../vendor/autoload.php';
$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'db' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'database' => 'db_name',
			'username' => 'username',
			'password' => 'password',
			'charset' => 'latin1',
			'collation' => 'latin1_swedish_ci',
			'prefix' => '',
		]
	
	],
]);
//Slim 3 DI Container
$container = $app->getContainer();

//Laravel's Elqouent Models for Powerful Database Access
//visit laravel.com
$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
	return $capsule;
};
//Symphony Twig Views
$container['view'] = function ($container){
	$view = new \Slim\Views\Twig('../resources/views', [
		'cache' => false,
	]);
//Custom Extensions
	$view->addExtension(new Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
	));
//Custom Globals
	$view->getEnvironment()->addGlobal('auth', [

		'check' => $container->auth->check(),
		'user' => $container->auth->user(),

	]);


	$view->getEnvironment()->addGlobal('Students', [

		'usr' => $container->auth->students(),
	]);


	$view->getEnvironment()->addGlobal('flash', $container->flash);

	return $view;
};

$container['auth'] = function($container) {
	return new \App\Auth\Auth;
};

$container['flash'] = function ($container) {
	return new \Slim\Flash\Messages;
};

//Form Validator RESPECT Validation Service
$container['validator'] = function ($container) {

	return new App\Validation\Validator;

};

//Register your controllers with Slim DI container
/*------------------Controllers------------------*/
$container['HomeController'] = function($container){

	return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){

	return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function($container){

	return new \App\Controllers\Auth\PasswordController($container);
};

$container['DashController'] = function($container){

	return new \App\Controllers\DashController($container);
};

$container['csrf'] = function($container) {
	return new \Slim\Csrf\Guard;
};

/*Middlewares*/
// Register Middlewares for global(all) routes
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

$app->add(new \App\Middleware\OldInputsMiddleware($container));

$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);
//Respect Validation Service 
//Custom Validation Rules
v::with('App\\Validation\\Rules\\');

//Main Routes Diffination 
require_once '../app/routes.php';
