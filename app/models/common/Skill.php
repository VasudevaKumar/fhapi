<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;


class Skill extends Model
{
    //
    public function getSkills()
	{

		$value = Cache::rememberForever('common_skills', function() {
    		$skills = app('db')->select("SELECT id , skillName as 'itemName' FROM jobskills");
			return $skills;
		});
		return $value;


	}

}
