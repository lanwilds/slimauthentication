<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->group('', function(){

	$this->get('/', 'HomeController:index')->setName('home');

	$this->post('/account/login', 'AuthController:postLogIn')->setName('auth.login');

	$this->get('/account/signin', 'AuthController:getSignIn')->setName('auth.signin');

});

//Authentication Routes
$app->group('', function() {
	$this->get('/account/signout', 'AuthController:getLogOut')->setName('auth.logout');
	
	$this->get('/account/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');

	$this->get('/dashboard', 'DashController:index')->setName('dash');

})->add(new AuthMiddleware($container));

$app->group('',function(){

})->add(new AuthMiddleware($container));
