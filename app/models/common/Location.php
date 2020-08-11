<?php

namespace App\models\common;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Location extends Model
{
	public function getLocations()
	{
		$value = Cache::rememberForever('common_locations', function() {
    		$locations = app('db')->select("SELECT * FROM locations");
			return $locations;
		});
		return $value;

	}
    
}
