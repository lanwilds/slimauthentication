<?php 

namespace App\Middleware;

class AuthMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{

		if(!$this->container->auth->check()) {

			$this->container->flash->addMessage('error', 'Please Sign In before proceding.');

			return $response->withRedirect($this->container->router->pathFor('home'));
		}

		$response = $next($request, $response);

		return $response;




	}

}