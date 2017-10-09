<?php 

namespace App\Middleware;

//Base Middleware

class Middleware
{

	protected $container;

	public function __construct($container)
	{

		$this->container = $container;

	} 


}