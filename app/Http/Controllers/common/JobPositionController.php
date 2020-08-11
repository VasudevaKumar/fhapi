<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\common\JobPosition;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;


class JobPositionController extends Controller
{
    //
    use ResponseHelper;

    public function __construct()
    {
        $this->setResponseToDefault();
    }
    public function index()
    {
    	$JobPositionModel = new JobPosition();
    	$result =  $JobPositionModel->getPositions();
    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }



}
