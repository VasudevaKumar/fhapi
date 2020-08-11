<?php

namespace App\Http\Controllers\profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\profiles\HR;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;
use Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\fh;

class HRcontroller extends Controller
{
    //
     use ResponseHelper;

    public function __construct()
    {
        $this->setResponseToDefault();
    }

    public function employeeRegister(Request $request)
    {

        $result = array();
        $data = $request->all();
        
      
       $dest_image_130 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_130');
       $dest_image_78 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_78');
       $dest_image_40 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_40');


        $profilePicNewName  = '';
        $resumeFileNewName = '';

        if($request->hasFile('fileSource')){
            $profilePic = $request->file('fileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();

             // Create 130 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(130, 130)
                ->save($dest_image_130 . $profilePicNewName);

            // Create 78 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(78, 78)
                ->save($dest_image_78 . $profilePicNewName);

                // Create 40 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(40, 40)
                ->save($dest_image_40 . $profilePicNewName);


        }


        if($profilePicNewName!='')
        {
            $data['profilePicPath'] =  env('DB_IMG').$profilePicNewName;
        }
        else{
            $data['profilePicPath'] = '';
          }

        $data['resumeFileNewName'] = $resumeFileNewName;


        $HRmodel = new HR();
        $alreadyPhoneAvailable = $HRmodel->verifyPhoneName($data);
      
        
        if(count($alreadyPhoneAvailable) == 0)
        {
            $result =  $HRmodel->employeeRegister($data);
            $this->setResponseData($result);
            $this->setStatusCode(200);
            $this->setResponseMessage('Fetch successful');
            return $this->getResponse();
        }
        else{
            $this->setResponseData($result);
            $this->setStatusCode(201);
            $this->setResponseMessage('Phone number is not available.('.$data['phoneNumber'].')');
            return $this->getResponse();
        }
       


    }



     public function getHRProfile(Request $request)
    {
        $data = $request->all();
        $HRmodel = new HR();
    	$result =  $HRmodel->getHRProfile($data);
    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();


    }

     public function getCompanyProfile(Request $request)
    {
        $data = $request->all();
        $HRmodel = new HR();
      $result =  $HRmodel->getCompanyProfile($data);
      $this->setResponseData($result);
    $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();


    }
    
    public function editHRProfile(Request $request)
    {
    	 $result = array();
       $data = $request->all();
        $HRmodel = new HR();

       $profilePicNewName = '';
       $resumeFileNewName = '';

       $dest_image_130 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_130');
       $dest_image_78 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_78');
       $dest_image_40 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F_40');


        $profilePicNewName  = '';
        $resumeFileNewName = '';

        if($request->hasFile('fileSource')){
            $profilePic = $request->file('fileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();

             // Create 130 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(130, 130)
                ->save($dest_image_130 . $profilePicNewName);

            // Create 78 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(78, 78)
                ->save($dest_image_78 . $profilePicNewName);

                // Create 40 px images 
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(40, 40)
                ->save($dest_image_40 . $profilePicNewName);


        }

        if($profilePicNewName!='')
        {
            $data['profilePicPath'] =  env('DB_IMG').$profilePicNewName;
        }
        else{
            $data['profilePicPath'] = '';
          }

        $HRmodel = new HR();
        $alreadyPhoneAvailable = $HRmodel->verifyPhoneNameEdit($data);


        if(count($alreadyPhoneAvailable) == 0)
        {
            $result =  $HRmodel->editHRProfile($data);
            $this->setResponseData($result);
            $this->setStatusCode(200);
            $this->setResponseMessage('Fetch successful');
            return $this->getResponse();

        }
        else{
            $this->setResponseData($result);
            $this->setStatusCode(201);
            $this->setResponseMessage('Phone number is not available.('.$data['phoneNumber'].')');
            return $this->getResponse();
        }
    }

     function verifyEmail(Request $request)
    {
       $result = array();
       $data = $request->all();
       $HRmodel = new HR();
       $result =  $HRmodel->verifyEmail($data);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }

    function verifyEmailForEdit(Request $request)
    {
       $result = array();
       $data = $request->all();
        $HRmodel = new HR();
       $result =  $HRmodel->verifyEmailForEdit($data);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }


     public function getSimilarProfiles(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getSimilarProfiles($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    }

    public function getComopanyUpdates(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getComopanyUpdates($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    } 
    public function pushUpdates(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->pushUpdates($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    } 

    public function getCompanyCareers(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getCompanyCareers($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    } 

     public function pushCareer(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->pushCareer($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    } 
    
     public function uploadHomePageFileL(Request $request)
    {
        $result = array();
        $data = $request->all();
        $dest_image = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_F');
        if($request->hasFile('leftSidefileSource')){
            $profilePic = $request->file('leftSidefileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();
             $profilePic->move($dest_image, $profilePicNewName);

            if($profilePicNewName!='')
            {
                $data['profilePicPath'] =  env('DB_IMG_HOME').$profilePicNewName;
            }
            else{
                $data['profilePicPath'] = '';
            }

        }

        $HRmodel = new HR();
        $result = $HRmodel->uploadHomePageFileL($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();
    }


     public function random(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->random($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();

    } 
    
    public function changePassword(Request $request)
    {
       
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->changePassword($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }

    public function submitJobPost(Request $request)
    {
       
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->submitJobPost($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }
    public function getJobPostings(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getJobPostings($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }
    public function statusChange(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->statusChange($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }

    public function getJobPostingByID(Request $request)
    {
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getJobPostingByID($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }

    public function editJobPost(Request $request)
    {
       
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->editJobPost($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }

    public function getActiveJobs(Request $request)
    {
       
      $data = $request->all();
      $HRmodel = new HR();
      $result =  $HRmodel->getActiveJobs($data);
      $this->setResponseData($result);
      $this->setStatusCode(200);
      $this->setResponseMessage('Fetch successful');
      return $this->getResponse();
    }
    



}
