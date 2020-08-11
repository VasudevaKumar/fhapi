<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\common\Location;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;

class LocationController extends Controller
{
    //
    use ResponseHelper;

    public function __construct()
    {
        $this->setResponseToDefault();
    }


    public function index()
    {
    	$locationModel = new Location();
    	$result =  $locationModel->getLocations();
    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }
}
