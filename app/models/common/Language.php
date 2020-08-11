<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Language extends Model
{
    //
    public function getLanguages()
	{
		$value = Cache::rememberForever('common_languages', function() {
    		$languages = app('db')->select("SELECT * FROM languages");
		return $languages;
		});
		return $value;


	}

}
