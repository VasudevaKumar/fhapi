<?php

namespace App\Http\Controllers\profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\profiles\Employee;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;
use Image;

class EmployeeController extends Controller
{
    //

     use ResponseHelper;

    public function __construct()
    {
        $this->setResponseToDefault();
    }


    public function getEmployeeInfo(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
    	$profileData =  $EmployeeModel->getEmployeeInfo($data);
    	$phoneNumbers = $EmployeeModel->getEmployeePhoneNumbers($data);
    	$professionalExp = $EmployeeModel->getProfessionalExp($data);
    	$userSkills = $EmployeeModel->getSkills($data);
    	$userResumes = $EmployeeModel->getResumes($data);
    	$userSocialLinks = $EmployeeModel->getSocialLinks($data);

    	$result['profileData'] =  $profileData;
    	$result['phoneNumbers'] =  $phoneNumbers;
    	$result['professionalExp'] =  $professionalExp;
    	$result['skills'] =  $userSkills;
    	$result['userResumes'] =  $userResumes;
    	$result['userSocialLinks'] =  $userSocialLinks;

    	$this->setResponseData($result);
		$this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();


    }
    public function getEmployeeHomDetails(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->getEmployeeHomDetails($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function getPeopleWhoMayKnow(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->peopleMayKnow($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function getEmployeeHomePics(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->getEmployeeHomePics($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }
    
     public function uploadHomePageFileL(Request $request)
    {
        $result = array();
        $data = $request->all();
        $dest_image = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE');
        if($request->hasFile('leftSidefileSource')){
            $profilePic = $request->file('leftSidefileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();
             $profilePic->move($dest_image, $profilePicNewName);
            /*
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(550, 175)
                ->save($dest_image . $profilePicNewName);
                */
               

           
/*
                Image::make($profilePic->getRealPath())->resize(550, 175,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->resizeCanvas(550, 175, 'center', false, array(195, 195, 199, 0))
                ->save($dest_image . $profilePicNewName, 80);
         */

            if($profilePicNewName!='')
            {
                $data['profilePicPath'] =  env('DB_IMG_HOME').$profilePicNewName;
            }
            else{
                $data['profilePicPath'] = '';
            }

        }

        $EmployeeModel = new Employee();
        $result = $EmployeeModel->uploadHomePageFileL($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();
    }

    public function uploadHomePageFileR(Request $request)
    {
        $result = array();
        $data = $request->all();
        $dest_image = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE');
        if($request->hasFile('rightSidefileSource')){
            $profilePic = $request->file('rightSidefileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();
            $profilePic->move($dest_image, $profilePicNewName);
            /*
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(550, 175)
                ->save($dest_image . $profilePicNewName);
            

                Image::make($profilePic->getRealPath())->resize(550, 175,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->resizeCanvas(550, 175, 'center', false, array(195, 195, 199, 0))
                ->save($dest_image . $profilePicNewName, 80);
            */
            if($profilePicNewName!='')
            {
                $data['profilePicPath'] =  env('DB_IMG_HOME').$profilePicNewName;
            }
            else{
                $data['profilePicPath'] = '';
            }

        }

        $EmployeeModel = new Employee();
        $result = $EmployeeModel->uploadHomePageFileR($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();
    }

     public function getPosts(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->getPosts($data);
        $mainArray = array();
        $count = count($result);


      
        for($i=0 ; $i < $count ; $i++)
        {
           $mainArray[$i]['posts'] = (array)$result[$i];
           //  echo 'ccccc'.$value['id'];
           
            $postcomments   = app('db')->select(" 
                                            SELECT 
                                                a.id,
                                                a.user_id,
                                                a.post_id,
                                                a.comments,
                                                a.created_at,
                                                b.firstName,
                                                b.lastName,
                                                b.imageProfile,
                                                t1.positionName, 
                                                t1.companyName
                                             FROM 
                                                postcomments a 
                                            JOIN
                                                posts p 
                                            ON
                                                a.post_id = p.id
                                             JOIN
                                                users b 
                                             ON
                                                a.user_id = b.id
                                             LEFT JOIN
                                                userprofessionalexperience t1 
                                              ON
                                                a.user_id = t1.user_id
                                             WHERE 
                                                t1.updated_at = (SELECT MAX(t2.updated_at)
                                                                  FROM userprofessionalexperience t2
                                                                    WHERE t2.user_id = t1.user_id)
                                             AND 
                                                a.post_id = ? " , [''.$result[$i]->id.'']  );

            $postLikes = app('db')->select(" 
                                            SELECT 
                                                count(*) as 'likeCount'
                                             FROM 
                                                postlikes a 
                                             WHERE 
                                                a.post_id = ? " , [''.$result[$i]->id.'']  );
            $psotShares = app('db')->select(" 
                                            SELECT 
                                                count(*) as 'shareCount'
                                             FROM 
                                                postsharing a 
                                             WHERE 
                                                a.post_id = ? " , [''.$result[$i]->id.'']  );


            $mainArray[$i]['posts']['comments'] = $postcomments;
            $mainArray[$i]['posts']['cnt_comments'] = count($postcomments);
            $mainArray[$i]['posts']['cnt_likes'] = $postLikes[0]->likeCount;
            $mainArray[$i]['posts']['cnt_shares'] = $psotShares[0]->shareCount;
          
        }


        $this->setResponseData($mainArray);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();



    }

    public function pushComments(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->pushComments($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function pushPost(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->pushPost($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }


     public function postImage(Request $request)
    {
        $result = array();
        $data = $request->all();
        $dest_image = $_SERVER['DOCUMENT_ROOT'].env('POST_IMAGE');
        if($request->hasFile('uploadImageSource')){
            $profilePic = $request->file('uploadImageSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();

            /*
            $thumb = Image::make($profilePic->getRealPath())
                ->resize(550, 175)
                ->save($dest_image . $profilePicNewName);
            */

                Image::make($profilePic->getRealPath())->resize(575, 575,
                    function ($constraint) {
                        $constraint->aspectRatio();
                    })
                ->resizeCanvas(575, 575, 'center')
                ->save($dest_image . $profilePicNewName, 80);

            if($profilePicNewName!='')
            {
                $data['profilePicPath'] =  env('DB_POST_IMAGE').$profilePicNewName;
            }
            else{
                $data['profilePicPath'] = '';
            }

        }

        $EmployeeModel = new Employee();
        $result = $EmployeeModel->postImage($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();
    }

    public function postSharing(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->postSharing($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function postLike(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->postLike($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function getConnectPeople(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->getConnectPeople($data);
        $count = count($result);
        $mainArray = [];
        $employeeID = $data['employeeID'];
       // echo '<pre>';
        //print_r($result);
        // exit();

        for($i=0 ; $i < $count ; $i++)
        {
           $mainArray[$i]['connections'] = (array)$result[$i];
           $connectID = $result[$i]->connect_id;


            if($connectID!='')
            {
                $mutualConnections   = app('db')->select("CALL ".env('DB_DATABASE').".sp_getMutualConnections (".$employeeID.", ".$connectID.")");

                $mainArray[$i]['connections']['mutual'] = $mutualConnections;
            }
            else{
                $mainArray[$i]['connections']['mutual'] = [];
            }
       
        }

        $this->setResponseData($mainArray);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();
    }

    public function connectme(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->connectme($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function getPendingRequests(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->getPendingRequests($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function acceptRequest(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->acceptRequest($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function followMe(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->followMe($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }
    
    public function gettotalConnects(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->gettotalConnects($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function addGroup(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->addGroup($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }
    public function gettotalGroups(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->gettotalGroups($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }
    public function addMeToGroup(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->addMeToGroup($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function addHashTag(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->addHashTag($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }

    public function verifyHashTag(Request $request)
    {
        $data = $request->all();
        $EmployeeModel = new Employee();
        $result = $EmployeeModel->verifyHashTag($data);
        $this->setResponseData($result);
        $this->setStatusCode(200);
        $this->setResponseMessage('Fetch successful');
        return $this->getResponse();

    }



    



}
