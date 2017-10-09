<?php 

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{


		@$this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

		unset($_SESSION['errors']);

		
		
		@$this->container->view->getEnvironment()->addGlobal('apperrors', $_SESSION['apperrors']);


		unset($_SESSION['apperrors']);



		@$this->container->view->getEnvironment()->addGlobal('pageerrors', $_SESSION['pageerrors']);


		unset($_SESSION['pageerrors']);



		$response = $next($request, $response);

		return $response;




	}

}