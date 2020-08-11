<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;


class Company extends Model
{
    //
    public function getCompanies()
	{

		$value = Cache::rememberForever('common_gender', function() {
    		$companies = app('db')->select("SELECT * FROM companies");
			return $companies;

		});
		return $value;

	}

}
