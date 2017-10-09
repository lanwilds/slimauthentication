<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//Database Model Eloquent for Admin Table
//For More Visit Laravel.com 
class Admin extends Model
{
	protected $table = 'admins';
	protected $primaryKey ='aid';

	protected $fillable = [
		'email',
		'name',
		'username',
		'password',
		'ip_addr'
	];

	public function setPassword($password)
	{
		
		$this->update([

			'password' => password_hash($password, PASSWORD_DEFAULT)

		]);
	}
}