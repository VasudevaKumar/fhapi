<?php

namespace App\models\profiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\fh;


class HR extends Model
{
    //

     public function getHRProfile($data)
	{
		$employeeID = $data['employeeID'];
		
		$employeeID = $data['employeeID'];
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getCompanyProfile (".$employeeID.")");
		return $employees;
		
	}

	 public function getCompanyProfile($data)
	{
		$employeeID = $data['employeeID'];
		
		$employeeID = $data['employeeID'];
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getSimilarCompanyProfile (".$employeeID.")");
		return $employees;
		
	}


	public function editHRProfile($data)
	{

		$modifiedDateTime = date('Y-m-d h:i:s');

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}

		$aboutCompany = '';
		$companyName = '';
		$companyContact = '';
		$designation = '';
		$phoneNumber = '';
		$profilePicPath = '';
		$sizeOfCompany = '';
		$ddlLocation = '';
		$companyAddress = '';

		$webSite = '';
		$Industry = '';
		$companyType = '';
		$Founded = '';
		$headQts = '';
		$specialties = '';


		$emailAddress ='';
		$password = '';
		
		$data['employeeID'] = $loggedInUser;
    	$profileData =  $this->getHRProfile($data);


    	if($data['aboutCompany'] != $profileData[0]->about){
			$aboutCompany = $data['aboutCompany'];
		}
		else{
			$aboutCompany = $profileData[0]->about;
		}

		if($data['companyName'] != $profileData[0]->companyName){
			$companyName = $data['companyName'];
		}
		else{
			$companyName = $profileData[0]->companyName;
		}

		if($data['companyContact'] != $profileData[0]->contactPersonName){
			$companyContact = $data['companyContact'];
		}
		else{
			$companyContact = $profileData[0]->contactPersonName;
		}
		if($data['designation'] != $profileData[0]->contactPersonDesignation){
			$designation = $data['designation'];
		}
		else{
			$designation = $profileData[0]->contactPersonDesignation;
		}
		if($data['designation'] != $profileData[0]->contactPersonDesignation){
			$designation = $data['designation'];
		}
		else{
			$designation = $profileData[0]->contactPersonDesignation;
		}

		if($data['phoneNumber'] != $profileData[0]->phoneNumber){
			$phoneNumber = $data['phoneNumber'];
		}
		else{
			$phoneNumber = $profileData[0]->phoneNumber;
		}

		if($data['emailAddress'] != $profileData[0]->emailAddress){
			$emailAddress = $data['emailAddress'];
		}
		else{
			$emailAddress = $profileData[0]->emailAddress;
		}

		if($data['sizeOfCompany'] != $profileData[0]->sizeOfCompany){
			$sizeOfCompany = $data['sizeOfCompany'];
		}
		else{
			$sizeOfCompany = $profileData[0]->sizeOfCompany;
		}

		if($data['sizeOfCompany'] != $profileData[0]->sizeOfCompany){
			$sizeOfCompany = $data['sizeOfCompany'];
		}
		else{
			$sizeOfCompany = $profileData[0]->sizeOfCompany;
		}


		if($data['ddlLocation'] != $profileData[0]->locationID){
			$ddlLocation = $data['ddlLocation'];
		}
		else{
			$ddlLocation = $profileData[0]->locationID;
		}

		if($data['ddlLocation'] != 'undefined'){
			$ddlLocation = $data['ddlLocation'];
		}
		else{
			$ddlLocation = $profileData[0]->locationID;
		}

		if($data['companyAddress'] != $profileData[0]->address){
			$companyAddress = $data['companyAddress'];
		}
		else{
			$companyAddress = $profileData[0]->address;
		}

		if($data['webSite'] != $profileData[0]->website){
			$webSite = $data['webSite'];
		}
		else{
			$webSite = $profileData[0]->website;
		}


		if($data['Industry'] != $profileData[0]->Industry){
			$Industry = $data['Industry'];
		}
		else{
			$Industry = $profileData[0]->Industry;
		}

		if($data['companyType'] != $profileData[0]->companyType){
			$companyType = $data['companyType'];
		}
		else{
			$companyType = $profileData[0]->companyType;
		}

		if($data['Founded'] != $profileData[0]->founded){
			$Founded = $data['Founded'];
		}
		else{
			$Founded = $profileData[0]->founded;
		}

		if($data['headQts'] != $profileData[0]->headQuarters){
			$headQts = $data['headQts'];
		}
		else{
			$headQts = $profileData[0]->headQuarters;
		}

		if($data['specialties'] != $profileData[0]->specialties){
			$specialties = $data['specialties'];
		}
		else{
			$specialties = $profileData[0]->specialties;
		}

 

		if(md5($data['password']) != $profileData[0]->password){
			$password = md5($data['password']);
		}
		else{
			$password = $profileData[0]->password;
		}

		if($data['profilePicPath']!= $profileData[0]->companyLogo){
			$profilePicPath = $data['profilePicPath'];
		}
		else{
			$profilePicPath = $profileData[0]->companyLogo;
		}



		
		// $webSite $Industry $companyType $Founded $headQts $specialties

		app('db')->beginTransaction();
		try {

		$result = app('db')->update("UPDATE `companyprofiles` SET 
											companyLogo = '".$profilePicPath."', 
											about = '".$aboutCompany."', 
											companyName = '".$companyName."', 
											contactPersonName = '".$companyContact."', 
											contactPersonDesignation = '".$designation."',  
											phoneNumber = '".$phoneNumber."', 
											sizeOfCompany = '".$sizeOfCompany."',  
											locationID = '".$ddlLocation."', 
											address = '".$companyAddress."',
											website = '".$webSite."',
											Industry = '".$Industry."',
											companyType = '".$companyType."',
											founded = '".$Founded."',
											headQuarters = '".$headQts."',
											specialties = '".$specialties."'
									WHERE 
											id = ?", [''.$loggedInUser.'']);

		
		$result = app('db')->update("UPDATE `users` SET 
											password = '".$password."', 
											emailAddress = '".$emailAddress."'
									WHERE 
											id = ?", [''.$loggedInUser.'']);
		app('db')->commit();
		}
			catch (\Exception $e) {
		    app('db')->rollback();
		    $returnMessage['msg'] = 'fail';
		    return $returnMessage;
		    
	    // something went wrong
		}

		$returnMessage['msg'] = 'success';
		return $returnMessage;



	}

	public function verifyEmail($data)
	{
		$userName = '';
		$password = '';

		if($data['emailAddress']!='')
		{
			$emailAddress = $data['emailAddress'];
		}
		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM users as a  
                                          WHERE 
                                          	a.emailAddress = ? AND role_id = 3 " , [''.$emailAddress.'']);
		
		return $employees;


	}

	public function employeeRegister($data)
	{
		
		$aboutCompany = '';
		$companyName = '';
		$companyContact = '';
		$designation = '';
		$phoneNumber = '';
		$profilePicPath = '';
		$sizeOfCompany = '';
		$ddlLocation = '';
		$companyAddress = '';
		$webSite = '';
		$Industry = '';
		$companyType = '';
		$Founded = '';
		$headQts = '';
		$specialties = '';

		
		$emailAddress ='';
		$password = '';
		$randomString = '';
		$randomCode = '';
		$hasher = app()->make('hash');

		if(isset($data['profilePicPath']))
		{
			$aboutCompany = $data['aboutCompany'];
		}

		if(isset($data['companyName']))
		{
			$companyName = $data['companyName'];
		}

		if(isset($data['companyContact']))
		{
			$companyContact = $data['companyContact'];
		}

		if(isset($data['designation']))
		{
			$designation = $data['designation'];
		}

		if(isset($data['phoneNumber']))
		{
			$phoneNumber = $data['phoneNumber'];
		}

		if(isset($data['profilePicPath']))
		{
			$profilePicPath = $data['profilePicPath'];
		}
		if(isset($data['sizeOfCompany']))
		{
			$sizeOfCompany = $data['sizeOfCompany'];
		}
		if(isset($data['ddlLocation']))
		{
			$ddlLocation = $data['ddlLocation'];
		}
		if(isset($data['companyAddress']))
		{
			$companyAddress = $data['companyAddress'];
		}

		if(isset($data['webSite']))
		{
			$webSite = $data['webSite'];
		}

		if(isset($data['Industry']))
		{
			$Industry = $data['Industry'];
		}

		if(isset($data['companyType']))
		{
			$companyType = $data['companyType'];
		}

		if(isset($data['Founded']))
		{
			$Founded = $data['Founded'];
		}

		if(isset($data['headQts']))
		{
			$headQts = $data['headQts'];
		}

		if(isset($data['specialties']))
		{
			$specialties = $data['specialties'];
		}

		if(isset($data['emailAddress']))
		{
			$emailAddress = $data['emailAddress'];
		}
		if(isset($data['password']))
		{
			// $password = md5($data['password']);
			$password = $hasher->make($data['password']);
		}

		$randomString = Str::random();
		$randomCode = substr(rand(), 0,4);
		


		app('db')->beginTransaction();
		try {
		$result = app('db')->insert("INSERT INTO `companyprofiles` 
									(companyLogo, about, companyName, contactPersonName, contactPersonDesignation, phoneNumber, sizeOfCompany,	locationID , address,	website , Industry, companyType, founded, headQuarters , specialties) 
									VALUES 	(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
									, 
									[''.$profilePicPath.'',''.$aboutCompany.'', ''.$companyName.'', ''.$companyContact.'', ''.$designation.'', ''.$phoneNumber.'', ''.$sizeOfCompany.'', ''.$ddlLocation.'', ''.$companyAddress.'', ''.$webSite.'' , ''.$Industry.'', ''.$companyType.'', ''.$Founded.'', ''.$headQts.'', ''.$specialties.'']
									);
		$lastInsertId=app('db')->getPdo()->lastInsertId();

	
		$result = app('db')->insert("INSERT INTO `users` (user_id, emailAddress, password,role_id,randomCode, randomString, status) 
									VALUES (?,?,?,?,?,?,?)", 
									[''.$lastInsertId.'', ''.$emailAddress.'', ''.$password.'', '3' , ''.$randomCode.'', ''.$randomString.'', 'P']
									);

		app('db')->commit();
		}
			catch (\Exception $e) {
		    app('db')->rollback();
		    $returnMessage['msg'] = 'fail';
		    return $returnMessage;
		    
	    // something went wrong
		}
			// $this->sendEmail($companyName , $emailAddress , $randomCode , $randomString);
			$returnMessage['msg'] = 'success';
			return $returnMessage;

	}


	public function verifyPhoneName($data)
	{

		if($data['phoneNumber']!='')
		{
			$phoneNumber = $data['phoneNumber'];
		}
		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM companyprofiles as a  
                                          WHERE 
                                          	a.phoneNumber = ? " , [''.$phoneNumber.'']);
		
		return $employees;


	}


	public function verifyEmailForEdit($data)
	{
		$emailAddress = '';
		$employeeID = '';

		if($data['emailAddress']!='')
		{
			$emailAddress = $data['emailAddress'];
		}
		if($data['employeeID']!='')
		{
			$employeeID = $data['employeeID']; 
		}

		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM users as a  
                                          WHERE 
                                          	a.emailAddress = ? AND  id <> ? AND role_id = 3 " , [''.$emailAddress.'' , ''.$employeeID.'']);
		
		return $employees;

	}

	public function verifyPhoneNameEdit($data)
	{
		$phoneNumber = '';
		$employeeID = '';

		if($data['phoneNumber']!='')
		{
			$phoneNumber = $data['phoneNumber'];
		}
		if($data['loggedInUser']!='')
		{
			$employeeID = $data['loggedInUser'];
		}

		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM companyprofiles as a  
                                          WHERE 
                                          	a.phoneNumber = ? AND id <> ?" , [''.$phoneNumber.'', ''.$employeeID.'']);
		
		return $employees;


	}


	 public function getSimilarProfiles($data)
	{
		$employeeID = $data['employeeID'];
		$Industry = $data['Industry'];
		
		$employeeID = $data['employeeID'];
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getSimilarCompanyProfiles (".$employeeID." ,  '".$Industry."')");
		return $employees;
		
	}

	 public function getComopanyUpdates($data)
	{
		$employeeID = $data['employeeID'];
		
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getCompanyUpdates (".$employeeID.")");
		return $employees;
		
	}

	 public function pushUpdates($data)
	{
		$employeeID = $data['employeeID'];
		$commentNotes = $data['commentNotes'];

		$result = app('db')->insert("INSERT INTO `companyupdates` (companyID, message) 
									VALUES (?,?)", 
									[''.$employeeID.'', ''.$commentNotes.'']
									);
		return $result;
	}

	 public function getCompanyCareers($data)
	{
		$employeeID = $data['employeeID'];
		
		$employees	 = app('db')->select("SELECT 
												a.careerDeatils,
												a.created_at
										 FROM companycareers as a  
                                          WHERE 
                                          	a.companyID = ? " , [''.$employeeID.'']);

		return $employees;
		
	}

	 public function pushCareer($data)
	{
		$employeeID = $data['employeeID'];
		$careerDetail = $data['careerDetail'];

		$result = app('db')->insert("INSERT INTO `companycareers` (companyID, careerDeatils) 
									VALUES (?,?)", 
									[''.$employeeID.'', ''.$careerDetail.'']
									);
		return $result;
	}

	public function uploadHomePageFileL($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		$leftsideimagepath = '';
		$loggedInUser = '';

		if(isset($data['profilePicPath']))
		{
			$leftsideimagepath = $data['profilePicPath'];
		}

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}


		$result = app('db')->update("UPDATE `companyprofiles` SET 
											companyProfilePicture = '".$leftsideimagepath."',
											updated_at = '".$modifiedDateTime."'
									WHERE 
											id = ? ", [''.$loggedInUser.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function random()
	{
		$return[] =  Str::random();
		$return[] =  substr(rand(), 0,4);
		return $return;

	}

	 public function sendEmail($companyName , $emailAddress , $randomCode , $randomString) {
        $fhEmail = new fh();
        $fhEmail->link = 'http://facehiring.com/activate/'.$randomString;
        $fhEmail->subject = $companyName.', your pin is '.$randomCode.'. Please confirm your email address';
        $fhEmail->name = $companyName;
        $fhEmail->activationCode = $randomCode;
        Mail::to($emailAddress, $companyName)->send($fhEmail);
    }

    public function changePassword($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');

		if(isset($data['password']))
		{
			$password = md5($data['password']);
		}

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}


		$result = app('db')->update("UPDATE `users` SET 
											password = '".$password."'
									WHERE 
											user_id = ? ", [''.$loggedInUser.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function submitJobPost($data)
	{
		$lookingFor = '';
		$jobLocation = '';
		$yearMin = '';
		$yearMax = '';
		$salMin = '';
		$salMax = '';
		$jobRole = '';
		$industryType = '';
		$functionalArea = '';
		$employmentType = '';
		$roleCategory = '';
		$requiredQualification = '';
		$jobDesription = '';
		$jobRes = '';
		$jobBenefit = '';
		$loggedInUser = '';

		if(isset($data['lookingFor']))
		{
			$lookingFor = $data['lookingFor'];
		}

		if(isset($data['jobLocation']))
		{
			$jobLocation = $data['jobLocation'];
		}

		if(isset($data['yearMin']))
		{
			$yearMin = $data['yearMin'];
		}

		if(isset($data['yearMax']))
		{
			$yearMax = $data['yearMax'];
		}

		if(isset($data['salMin']))
		{
			$salMin = $data['salMin'];
		}

		if(isset($data['salMax']))
		{
			$salMax = $data['salMax'];
		}

		if(isset($data['jobRole']))
		{
			$jobRole = $data['jobRole'];
		}

		if(isset($data['industryType']))
		{
			$industryType = $data['industryType'];
		}

		if(isset($data['functionalArea']))
		{
			$functionalArea = $data['functionalArea'];
		}

		if(isset($data['employmentType']))
		{
			$employmentType = $data['employmentType'];
		}

		if(isset($data['roleCategory']))
		{
			$roleCategory = $data['roleCategory'];
		}
		if(isset($data['requiredQualification']))
		{
			$requiredQualification = $data['requiredQualification'];
		}

		if(isset($data['jobDesription']))
		{
			$jobDesription = $data['jobDesription'];
		}

		if(isset($data['jobRes']))
		{
			$jobRes = $data['jobRes'];
		}

		if(isset($data['jobBenefit']))
		{
			$jobBenefit = $data['jobBenefit'];
		}

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}


		$result = app('db')->insert("INSERT INTO `jobpostings` (user_id, lookingFor, jobLocation, yearMin, yearMax,	salMin, salMax, jobRole, industryType, functionalArea, employmentType, roleCategory, requiredQualification, jobDesription, jobRes, jobBenefit) 
									VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", 
									[''.$loggedInUser.'', ''.$lookingFor.'', ''.$jobLocation.'', ''.$yearMin.'',''.$yearMax.'',''.$salMin.'',''.$salMax.'',''.$jobRole.'',''.$industryType.'',''.$functionalArea.'',''.$employmentType.'',''.$roleCategory.'', ''.$requiredQualification.'', ''.$jobDesription.'', ''.$jobRes.'', ''.$jobBenefit.'']
									);
		
		$returnMessage['msg'] = 'success';
		return $returnMessage;

	}

	 public function getJobPostings($data)
	{
		$employeeID = $data['employeeID'];

		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getCompanyJobPostings (".$employeeID.")");
		return $employees;
		
	}

	public function statusChange($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}
		if(isset($data['rowid']))
		{
			$rowid = $data['rowid'];
		}
		if(isset($data['action']))
		{
			$action = $data['action'];
		} 	

		if($action!='D')
		{
			$result = app('db')->update("UPDATE `jobpostings` SET 
												status = ?
										WHERE 
												id = ? ", [''.$action.'', ''.$rowid.'']);
		}
		else{
			$result = app('db')->update("UPDATE `jobpostings` SET 
												status = ? , deleted_at = ?
										WHERE 
												id = ? ", [''.$action.'', ''.$modifiedDateTime.'', ''.$rowid.'']);
		}
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	 public function getJobPostingByID($data)
	{
		$employeeID = $data['employeeID'];
		$rowID = $data['rowID'];
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getCompanyJobPostingById (".$employeeID." , ".$rowID.")");
		return $employees;
		
	}


	public function editJobPost($data)
	{
		$lookingFor = '';
		$jobLocation = '';
		$yearMin = '';
		$yearMax = '';
		$salMin = '';
		$salMax = '';
		$jobRole = '';
		$industryType = '';
		$functionalArea = '';
		$employmentType = '';
		$roleCategory = '';
		$requiredQualification = '';
		$jobDesription = '';
		$jobRes = '';
		$jobBenefit = '';
		$loggedInUser = '';
		$rowID = '';

		if(isset($data['lookingFor']))
		{
			$lookingFor = $data['lookingFor'];
		}

		if(isset($data['jobLocation']))
		{
			$jobLocation = $data['jobLocation'];
		}

		if(isset($data['yearMin']))
		{
			$yearMin = $data['yearMin'];
		}

		if(isset($data['yearMax']))
		{
			$yearMax = $data['yearMax'];
		}

		if(isset($data['salMin']))
		{
			$salMin = $data['salMin'];
		}

		if(isset($data['salMax']))
		{
			$salMax = $data['salMax'];
		}

		if(isset($data['jobRole']))
		{
			$jobRole = $data['jobRole'];
		}

		if(isset($data['industryType']))
		{
			$industryType = $data['industryType'];
		}

		if(isset($data['functionalArea']))
		{
			$functionalArea = $data['functionalArea'];
		}

		if(isset($data['employmentType']))
		{
			$employmentType = $data['employmentType'];
		}

		if(isset($data['roleCategory']))
		{
			$roleCategory = $data['roleCategory'];
		}
		if(isset($data['requiredQualification']))
		{
			$requiredQualification = $data['requiredQualification'];
		}

		if(isset($data['jobDesription']))
		{
			$jobDesription = $data['jobDesription'];
		}

		if(isset($data['jobRes']))
		{
			$jobRes = $data['jobRes'];
		}

		if(isset($data['jobBenefit']))
		{
			$jobBenefit = $data['jobBenefit'];
		}

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}
		if(isset($data['rowID']))
		{
			$rowID = $data['rowID'];
		}


		$result = app('db')->UPDATE("UPDATE 
											`jobpostings` 
										SET
											lookingFor = ?,
											jobLocation = ?,
											yearMin = ?,
											yearMax = ?,
											salMin = ?,
											salMax = ?,
											jobRole = ?,
											industryType = ?,
											functionalArea = ?,
											employmentType = ?,
											roleCategory = ?,
											requiredQualification = ?,
											jobDesription = ?,
											jobRes = ?,
											jobBenefit = ?
										WHERE 
											id = ?
										AND
											user_id = ? ", [''.$lookingFor.'', ''.$jobLocation.'', ''.$yearMin.'',''.$yearMax.'',''.$salMin.'',''.$salMax.'',''.$jobRole.'',''.$industryType.'',''.$functionalArea.'',''.$employmentType.'',''.$roleCategory.'', ''.$requiredQualification.'', ''.$jobDesription.'', ''.$jobRes.'', ''.$jobBenefit.'', ''.$rowID.'' , ''.$loggedInUser.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;

	}

	public function getActiveJobs($data)
	{
		$employeeID = $data['employeeID'];
		$employees	 = app('db')->select("CALL ".env('DB_DATABASE').".HR_getCompanyActiveJobPostings (".$employeeID.")");
		return $employees;
		
	}



}
