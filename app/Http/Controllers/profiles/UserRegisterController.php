<?php

namespace App\Http\Controllers\profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\profiles\UserRegister;
use App\Services\Helper\ResponseHelper;
use App\Services\Helper\AcitvationUpdateHelper;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Image;
use Cache;



class UserRegisterController extends Controller
{
    //
    use ResponseHelper;
     protected $jwt;
   
    public function __construct( JWTAuth $jwt )
    {
        $this->setResponseToDefault();
         $this->jwt = $jwt;
    }

     public function index(Request $request)
    {

        $result = array();
        $data = $request->all();
        
       $dest_image_130 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_130');
       $dest_image_78 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_78');
       $dest_image_40 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_40');

       // $dest_image = env('DEST_IMAGE');
       $dest_file = $_SERVER['DOCUMENT_ROOT'].env('DEST_FILE');

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

        if($request->hasFile('fileInput')){
            $resumeFile = $request->file('fileInput');
            $resumeFileNewName   = time() . '.' . $resumeFile->getClientOriginalName();
            $resumeFile->move($dest_file, $resumeFileNewName);
        }

        if($profilePicNewName!='')
        {
            $data['profilePicPath'] =  env('DB_IMG').$profilePicNewName;
        }
        else{
            $data['profilePicPath'] = '';
        }
        if($resumeFileNewName!=''){
            $data['resumeFilePath'] =  env('DB_FILE').$resumeFileNewName;    
        }else {
            $data['resumeFilePath'] = '';
        }

        $data['resumeFileNewName'] = $resumeFileNewName;

        $UserRegister = new UserRegister();
        $alreadyPhoneAvailable = $UserRegister->verifyPhoneName($data);
        if(count($alreadyPhoneAvailable) == 0)
        {
            $result =  $UserRegister->register($data);
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

    function editProfile(Request $request)
    {
       $result = array();
       $profilePicNewName = '';
       $resumeFileNewName = '';

       $dest_image_130 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_130');
       $dest_image_78 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_78');
       $dest_image_40 = $_SERVER['DOCUMENT_ROOT'].env('DEST_IMAGE_40');

       // $dest_image = env('DEST_IMAGE');
       $dest_file = $_SERVER['DOCUMENT_ROOT'].env('DEST_FILE');

      // $destinationFolder = $_SERVER['DOCUMENT_ROOT'].'/profile/assets/files';

        if($request->hasFile('fileSource')){
            $profilePic = $request->file('fileSource');
            $profilePicNewName   = time() . '.' . $profilePic->getClientOriginalName();
            //$profilePic->move($destinationFolder.'/profilePics', $profilePicNewName);

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
        if($request->hasFile('fileInput')){
            $resumeFile = $request->file('fileInput');
            $resumeFileNewName   = time() . '.' . $resumeFile->getClientOriginalName();
            $resumeFile->move($dest_file.'/resumes', $resumeFileNewName);
        }

        $data = $request->all();

        if($profilePicNewName!='')
        {
            $data['profilePicPath'] =  env('DB_IMG').$profilePicNewName;
        }
        else{
            $data['profilePicPath'] = '';
        }
        if($resumeFileNewName!=''){
            $data['resumeFilePath'] =  env('DB_FILE').$resumeFileNewName;    
        }else {
            $data['resumeFilePath'] = '';
        }

        // echo $data['profilePicPath'];

        $data['resumeFileNewName'] = $resumeFileNewName;


        $UserRegister = new UserRegister();

        $alreadyPhoneAvailable = $UserRegister->verifyPhoneNameEdit($data);

        if(count($alreadyPhoneAvailable) == 0)
        {
                    $result =  $UserRegister->editProfile($data);
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

    function verifyLogin(Request $request)
    {
       $result = array();
       $data = $request->all();
       $result = $this->postLogin($request);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }

    function verifyUserName(Request $request)
    {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->verifyUserName($data);

       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }

    function verifyEmail(Request $request)
    {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->verifyEmail($data);

       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }
    

    
    function verifyEmailForEdit(Request $request)
    {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->verifyEmailForEdit($data);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();

    }


  function activate(Request $request)
   {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->activate($data);
       
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();
       

    }

    function forgotPassWord(Request $request)
   {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->forgotPassWord($data);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();
       

    }

    function modifyPassword(Request $request)
   {
       $result = array();
       $data = $request->all();
       $UserRegister = new UserRegister();
       $result =  $UserRegister->modifyPassword($data);
       $this->setResponseData($result);
       $this->setStatusCode(200);
       $this->setResponseMessage('Fetch successful');
       return $this->getResponse();
       

    }

   public function postLogin(Request $request)
    {
        $this->validate($request, [
            'emailAddress'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        
        try {
            
            if (! $token = $this->jwt->attempt($request->only('emailAddress', 'password', 'role_id'))) {
                //return response()->json(['user_not_found'], 404);
                $message['msg'] = 'fail';
                $message['returnMessage'] = 'user_not_found';
                return $message;
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            // return response()->json(['token_expired'], 500);
            $message['msg'] = 'fail';
            $message['returnMessage'] = 'token_expired';
            return $message;

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            //return response()->json(['token_invalid'], 500);
          $message['msg'] = 'fail';
          $message['returnMessage'] = 'token_invalid';
          return $message;

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            // return response()->json(['token_absent' => $e->getMessage()], 500);
          $message['msg'] = 'fail';
          $message['returnMessage'] = 'token_absent';
          return $message;

        }

         // return response()->json(compact('token'));
        // $token;
        $message['msg'] = 'sucess';
        $message['token'] = $token;

        return $message;
    }
    
    public function getAuthenticatedUser(Request $request)
    {
        try {

            if (! $user = $this->jwt->parseToken()->authenticate($request->only('emailAddress', 'password', 'role_id'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }


    

}
