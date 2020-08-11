<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;

class JobPosition extends Model
{
    //
    public function getPositions()
	{
		
		$value = Cache::rememberForever('common_positions', function() {
    		$positions = app('db')->select("SELECT * FROM jobpositions");
			return $positions;
		});
		return $value;

	}

}
