<?php 

namespace App\Middleware;

class OldInputsMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{


		@$this->container->view->getEnvironment()->addGlobal('appold', $_SESSION['appold']);
		@$this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);

		$_SESSION['appold'] = $request->getParams();
		$_SESSION['old'] = $request->getParams();

		$response = $next($request, $response);

		return $response;




	}

}