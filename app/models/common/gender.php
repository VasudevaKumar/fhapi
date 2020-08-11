<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;


class gender extends Model
{
    //
    public function getGenders()
	{
		$genders = app('db')->select("SELECT * FROM genders");
		return $genders;

	}
    

}
