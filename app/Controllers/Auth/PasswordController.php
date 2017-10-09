<?php 


namespace App\Controllers\Auth;

use App\Models\Admin;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
	public function getChangePassword($request, $response)
	{
		return $this->view->render($response, 'auth/password/change.twig');
	}

	public function postChangePassword($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'password_old' => v::noWhitespace()->notEmpty()->length(5, 15)->matchesPassword($this->auth->user()->password),
			'password' => v::noWhitespace()->notEmpty()->length(5, 15),
		]);

		if($validation->failed())
		{
			return $response->withRedirect($this->router->pathFor('auth.password.change'));
		}
		$this->auth->user()->setPassword($request->getParam('password'));

		$this->flash->addMessage('success', 'Password Changed Successful.');

		return $response->withRedirect($this->router->pathFor('home'));
		
	}
} 
