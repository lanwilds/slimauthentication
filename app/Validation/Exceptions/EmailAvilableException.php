<?php 


namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException; 

class EmailAvilableException extends ValidationException
{

	public static $defaultTemplates = [

		self::MODE_DEFAULT => [

			self::STANDARD => 'Email is already taken.',

		],

	];
}