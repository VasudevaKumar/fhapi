<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\common\Company;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;


class CompaniesController extends Controller
{
    //
    use ResponseHelper;

    public function __construct()
    {
        $this->setResponseToDefault();
    }
    public function index()
    {

    	$CompanyModel = new Company();
    	$result =  $CompanyModel->getCompanies();
    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

}
