<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
	protected $table = 'visitors';
	protected $primaryKey ='vid';

	protected $fillable = [
		'vip',
		'url',
		'browser',
	];

}