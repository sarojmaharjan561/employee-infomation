<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $fillable = ['name','department_id','email','joined_date'];
}
