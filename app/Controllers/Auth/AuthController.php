<?php 

namespace App\Controllers\Auth;

use App\Models\Admin;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class AuthController extends Controller
{
	public function getLogOut($request, $response)
	{
		$this->auth->logout();
		$this->flash->addMessage('success', 'You have been Logged Out');

		return $response->withRedirect($this->router->pathFor('auth.signin'));
	}

	public function getSignIn($request, $response)
	{
		return $this->view->render($response, 'auth/signin.twig');
	}


	public function postLogIn($request, $response)
	{
		$auth = $this->auth->attempt(
			$request->getParam('email'),

			$request->getParam('password')

		);

		if(!$auth)
		{
			$this->flash->addMessage('error', 'Could Not Login, Invalid Credentials');

			return $response->withRedirect($this->router->pathFor('home'));
		}

		$this->flash->addMessage('info', 'You have been Logged In!');
		return $response->withRedirect($this->router->pathFor('home'));

	}

	public function getSignUp($request, $response)
	{
		return $this->view->render($response, 'auth/signup.twig');
	}


	public function postSignUp($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty()->emailAvilable(),
			
			'username' => v::notEmpty()->alpha()->length(5, 15),
			
			'password' => v::noWhitespace()->notEmpty()->length(8, 50),


		]);

		if($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('auth.signup'));
		}


		$user = Admin::create([
			'email' => $request->getParam('email'),
			'username' => $request->getParam('username'),
			'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
		]);

		$this->flash->addMessage('info', 'New user added successful!');

		return $response->withRedirect($this->router->pathFor('dash'));

	}
}
