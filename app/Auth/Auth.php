<?php

namespace App\Auth;

use App\Models\Student;

class Auth
{
	public function user()
	{
		return @Student::find($_SESSION['user']);
	}

	public function check()
	{
		return @isset($_SESSION['user']);
	}

//Authentication Attempts
	public function attempt($email, $password)
	{
		$user = Student::where('email', $email)->first();
		
		if(!$user)
		{
			return false;
		}

		if(password_verify($password, $user->password))
		{
			$_SESSION['user'] = $user->aid;
			Student::where('sid', $_SESSION['user'])->update([
			'ip_addr' => $_SERVER['REMOTE_ADDR'],
		]);
			return true;
		}

		return false;
	}

	public function logout()
	{
		unset($_SESSION['user']);
	}

	public function students()
	{
		return Student::all();
	}

}