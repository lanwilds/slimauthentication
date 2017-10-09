<?php


namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

use App\Models\Admin;

class EmailAvilable extends AbstractRule
{

	public function validate($input)
	{
		$email = Admin::where('email', $input)->count();
		if($email == false){ return true; }
		$email = Admin::where('email', $input)->where('aid', $_SESSION['user'])->get();
		foreach($email as $mail) 
		{
			if( $mail->email == $input)
			{
				return true; 
			}
		}
		return false;
	}

}