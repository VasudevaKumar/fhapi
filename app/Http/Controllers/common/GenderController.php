<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\common\gender;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;

class GenderController extends Controller
{
    //
    use ResponseHelper;
    public function __construct()
    {
        $this->setResponseToDefault();
    }
    public function index()
    {
    	$genderModel = new gender();
    	$result =  $genderModel->getGenders();
    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

}
