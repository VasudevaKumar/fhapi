<?php

namespace App\models\profiles;
use Illuminate\Database\Eloquent\Model;
use App\models\profiles\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\fh;
// use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRegister extends Model
{
    //

    public function register($data)
	{
		/*
		$users = app('db')->select("SELECT * FROM companies");
		return $users;
		*/

// 		$result=app('db')->insert("INSERT INTO table...");
		
		/*
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		

		return;
		*/

		/* Users table */
        $firstName = '';
        $lastName = '';
        $username = '';
        $password = '';
        $birthDateMonth = '';
        $birthDateDate = '';
        $birthDateYear = '';
        $dob = '';
        $emailAddress = '';
        $bio = '';
        $organization = '';
        $website = '';
        $ddlLocation = '';
        $imageProfile = '';
        $birthDateGender = '';
        
        /* userphonedetails table */
        $phoneNumber = '';
        $altphoneNumber = '';

        /* userlanguages table */
        $language = '';
        
        /* 	userskills table */
        $skills = '';
        
        /*usersocialprofilelinks table */
	    $InstagramLink = '';
	    $FacebookLink = '';
	    $TwitterLink = '';
	    $YoutubeLink = '';
	    $GithubLink = '';

	    /*userprofessionalexperience table */
	    $fromDate1 = '';
	    $toDate1 = '';
	    $ddlCompany1 = '';
	    $ddlPosition1 = '';

	    /*userresumedetails*/
	    $resumeFilePath = '';

	    $returnMessage = [];

	    /*
		$result = app('db')->insert('insert into userresumedetails (user_id , resumePath) values (?, ?)', [1, 'Dayle']);
		$lastInsertId=app('db')->getPdo()->lastInsertId();
		return $lastInsertId;
		*/ 

		if(isset($data['firstName']))
		{
			$firstName = $data['firstName'];
		}

		if(isset($data['lastName']))
		{
			$lastName = $data['lastName'];
		}
		if(isset($data['username']))
		{
			$username = $data['username'];
		}

		if(isset($data['password']))
		{
			$password = md5($data['password']);
		}

		if(isset($data['birthDateMonth']) && isset($data['birthDateDate']) && isset($data['birthDateYear']))
		{
			$dob = 	$data['birthDateYear'].'-'.$data['birthDateMonth'].'-'.$data['birthDateDate'];
		}

		if(isset($data['emailAddress']))
		{
			$emailAddress = $data['emailAddress'];
		}

		if(isset($data['bio']))
		{
			$bio = $data['bio'];
		}

		if(isset($data['organization']))
		{
			$organization = $data['organization'];
		}

		if(isset($data['website']))
		{
			$website = $data['website'];
		}

		if(isset($data['ddlLocation']))
		{
			$ddlLocation = $data['ddlLocation'];
		}

		if(isset($data['birthDateGender']))
		{
			$birthDateGender = $data['birthDateGender'];
		}
		if(isset($data['profilePicPath']))
		{
			$profilePicPath = $data['profilePicPath'];
		}
		if(isset($data['resumeFilePath']))
		{
			$resumeFilePath = $data['resumeFilePath'];
		}

		/* Phons */
		if(isset($data['phoneNumber']))
		{
			$phoneNumber = $data['phoneNumber'];
		}
		if(isset($data['altphoneNumber']))
		{
			$altphoneNumber = $data['altphoneNumber'];
		}

		/* Language */
		if(isset($data['language']))
		{
			$language = $data['language'];
		}

		/* 	userskills table */
     
        if(isset($data['skills']))
		{
			$skillArray = explode(',', $data['skills']);
		}

		/*usersocialprofilelinks table */

	    if(isset($data['InstagramLink']))
	    {
	    	$profileLinks[1] = $data['InstagramLink'];
	    }
	    if(isset($data['FacebookLink']))
	    {
	    	$profileLinks[2] = $data['FacebookLink'];
	    }
	    if(isset($data['TwitterLink']))
	    {
	    	$profileLinks[3] = $data['TwitterLink'];
	    }
	    if(isset($data['YoutubeLink']))
	    {
	    	$profileLinks[4] = $data['YoutubeLink'];
	    }
	    if(isset($data['GithubLink']))
	    {
	    	$profileLinks[5] = $data['GithubLink'];
	    }

	    
	    if(isset($data['fromDate1']))
		{
			$fromDate1 = substr($data['fromDate1'],4,11);
			$fromDate1 = date('Y-m-d', strtotime($fromDate1));

		}
		if(isset($data['toDate1']))
		{
			$toDate1 = substr($data['toDate1'],4,11);
			$toDate1 = date('Y-m-d', strtotime($fromDate1));

		}
		if(isset($data['ddlCompany1']))
		{
			$ddlCompany1 = $data['ddlCompany1'];
		}
		if(isset($data['ddlPosition1']))
		{
			$ddlPosition1 = $data['ddlPosition1'];
		}

		if(isset($data['resumeFilePath']))
		{
			$resumeFilePath = $data['resumeFilePath'];
		}

		if(isset($data['resumeFileNewName']))
		{
			$resumeFileNewName = $data['resumeFileNewName'];
		}


		/*userresumedetails*/

		/* User table */

		app('db')->beginTransaction();
		try {
		$result = app('db')->insert("INSERT INTO `jobseekerprofiles` 
									(firstName, lastName, userName, password, dob, emailAddress, about,	organization, website,	gender,	locationID, imageProfile) 
									VALUES 	(?,?,?,?,?,?,?,?,?,?,?,?)"
									, 
									[''.$firstName.'',''.$lastName.'', ''.$username.'', ''.$password.'', ''.$dob.'', ''.$emailAddress.'', ''.$bio.'', ''.$organization.'', ''.$website.'', ''.$birthDateGender.'',''.$ddlLocation.'', ''.$profilePicPath.''
																]
									);
		$lastInsertId=app('db')->getPdo()->lastInsertId();


		$result = app('db')->insert("INSERT INTO `users` (user_id, emailAddress, password,role_id) 
									VALUES (?,?,?,?)", 
									[''.$lastInsertId.'', ''.$emailAddress.'', ''.$password.'', '2']
									);


		/* userphonedetails table */
		$result = app('db')->insert("INSERT INTO `userphonedetails` (user_id, phoneNumber, isPrimary) 
									VALUES (?,?,?)", 
									[''.$lastInsertId.'', ''.$phoneNumber.'','Y']
									);

		$result = app('db')->insert("INSERT INTO `userphonedetails` (user_id, phoneNumber, isPrimary) 
									VALUES (?,?,?)", 
									[''.$lastInsertId.'', ''.$altphoneNumber.'','N']
									);
		/* Languages */

		$result = app('db')->insert("INSERT INTO `userlanguages` (user_id, languageID) 
									VALUES (?,?)", 
									[''.$lastInsertId.'', ''.$language.'']
									);

		/* Skills */
		foreach($skillArray as $key=>$skillID)
		{
			if($skillID > 0)
			{
				$result = app('db')->insert("INSERT INTO `userskills` (user_id, skillID) 
									VALUES (?,?)", 
									[''.$lastInsertId.'', ''.$skillID.'']
									);
			}
		}
		
		/* profile links */
		foreach($profileLinks as $key=>$profileValue)
		{
			$result = app('db')->insert("INSERT INTO `usersocialprofilelinks` (user_id, socialProfileID , socialProfile) 
									VALUES (?,?, ?)", 
									[''.$lastInsertId.'', ''.$key.'', ''.$profileValue.'']
									);
		}

		/* userprofessionalexperience */
		$result = app('db')->insert("INSERT INTO `userprofessionalexperience` (user_id, fromDate , toDate , companyName , positionName ) VALUES (?,?,?,?,?)", 
									[''.$lastInsertId.'', ''.$fromDate1.'' , ''.$toDate1.'',''.$ddlCompany1.'',''.$ddlPosition1.'' ]
									);
		/* userresumedetails */

		$result = app('db')->insert("INSERT INTO `userresumedetails` (user_id, resumePath,resumeName) VALUES (?,?,?)", 
									[''.$lastInsertId.'', ''.$resumeFilePath.'', ''.$resumeFileNewName.'']
									);

		$result = app('db')->insert("INSERT INTO `userhomepageimages` (user_id) VALUES (?)", 
									[''.$lastInsertId.'']
									);
		
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

	public function editProfile($data)
	{


		$modifiedDateTime = date('Y-m-d h:i:s');

		/* Users table */
        $firstName = '';
        $lastName = '';
        $username = '';
        $password = '';
        $birthDateMonth = '';
        $birthDateDate = '';
        $birthDateYear = '';
        $dob = '';
        $emailAddress = '';
        $bio = '';
        $organization = '';
        $website = '';
        $ddlLocation = '';
        $imageProfile = '';
        $birthDateGender = '';
        
        /* userphonedetails table */
        $phoneNumber = '';
        $altphoneNumber = '';

        /* userlanguages table */
        $language = '';
        
        /* 	userskills table */
        $skills = '';
        
        /*usersocialprofilelinks table */
	    $InstagramLink = '';
	    $FacebookLink = '';
	    $TwitterLink = '';
	    $YoutubeLink = '';
	    $GithubLink = '';

	    /*userprofessionalexperience table */
	    $fromDate1 = '';
	    $toDate1 = '';
	    $ddlCompany1 = '';
	    $ddlPosition1 = '';

	    /*userresumedetails*/
	    $resumeFilePath = '';

	    $returnMessage = [];

	    $loggedInUser = '';
	    /*
		$result = app('db')->insert('insert into userresumedetails (user_id , resumePath) values (?, ?)', [1, 'Dayle']);
		$lastInsertId=app('db')->getPdo()->lastInsertId();
		return $lastInsertId;
		*/ 
		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}
		
		$employeeIDArray['employeeID'] = $loggedInUser;

		$EmployeeModel = new Employee();
    	$profileData =  $EmployeeModel->getEmployeeInfo($employeeIDArray);
    	$phoneNumbers = $EmployeeModel->getEmployeePhoneNumbers($employeeIDArray);
    	$userSkills = $EmployeeModel->getSkills($employeeIDArray);
    	$userSocialLinks = $EmployeeModel->getSocialLinks($employeeIDArray);
    	$professionalExp = $EmployeeModel->getProfessionalExp($employeeIDArray);
		$userResumes = $EmployeeModel->getResumes($employeeIDArray);
    	
    	/*
    	echo '<pre>';
    	print_r($userResumes);
    	echo '</pre>';
			*/


    	$existingSkills = '';

    	$existingDOB = $profileData[0]->dob;
    	//echo $existingDOB;
    	
    	$existingDOBArray = explode('-', $existingDOB);
    	$existingDOBYear = $existingDOBArray[0];
    	$existingDOBMonth = $existingDOBArray[1];
    	$existingDOBDate = $existingDOBArray[2];
    	foreach($userSkills as $key=>$value)
    	{
    		$existingSkills .= $value->id.',';
    	}
    	
    	
		if($data['firstName'] != $profileData[0]->firstName){
			$firstName = $data['firstName'];
		}
		else{
			$firstName = $profileData[0]->firstName;
		}


		if($data['lastName'] != $profileData[0]->lastName){
			$lastName = $data['lastName'];
		}
		else{
			$lastName = $profileData[0]->lastName;
		}


		if(md5($data['password']) != $profileData[0]->password){
			$password = md5($data['password']);
		}
		else{
			$password = $profileData[0]->password;
		}
		if($data['birthDateMonth']!= $existingDOBMonth){
			$birthDateMonth = $data['birthDateMonth'];
		}
		else{
			$birthDateMonth = $existingDOBMonth;
		}
		if($data['birthDateDate']!= $existingDOBDate){
			$birthDateDate = $data['birthDateDate'];
		}
		else{
			$birthDateDate = $existingDOBDate;
		}
		if($data['birthDateYear']!= $existingDOBYear){
			$birthDateYear = $data['birthDateYear'];
		}
		else{
			$birthDateYear = $existingDOBYear;
		}
		$dob = 	$birthDateYear.'-'.$birthDateMonth.'-'.$birthDateDate;

		if($data['emailAddress']!= $profileData[0]->emailAddress){
			$emailAddress = $data['emailAddress'];
		}
		else{
			$emailAddress = $profileData[0]->emailAddress;
		}
		if($data['bio']!= $profileData[0]->about){
			$bio = $data['bio'];
		}
		else{
			$bio = $profileData[0]->about;
		}
		if($data['organization']!= $profileData[0]->organization){
			$organization = $data['organization'];
		}
		else{
			$organization = $profileData[0]->organization;
		}
		if($data['website']!= $profileData[0]->website){
			$website = $data['website'];
		}
		else{
			$website = $profileData[0]->website;
		}
		if($data['birthDateGender']!= $profileData[0]->gender){
			$birthDateGender = $data['birthDateGender'];
		}
		else{
			$birthDateGender = $profileData[0]->gender;
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

		if($data['profilePicPath']!= $profileData[0]->imageProfile){
			$profilePicPath = $data['profilePicPath'];
		}
		else{
			$profilePicPath = $profileData[0]->imageProfile;
		}


		app('db')->beginTransaction();
		try {

		$result = app('db')->update("UPDATE `jobseekerprofiles` SET 
											firstName = '".$firstName."', 
											lastName = '".$lastName."', 
											password = '".$password."', 
											dob = '".$dob."', 
											emailAddress = '".$emailAddress."',  
											about = '".$bio."', 
											organization = '".$organization."',  
											website = '".$website."', 
											gender = '".$birthDateGender."', 	
											locationID = '".$ddlLocation."', 
											imageProfile = '".$profilePicPath."'
									WHERE 
											id = ?", [''.$loggedInUser.'']);

		
		$result = app('db')->update("UPDATE `users` SET 
											password = '".$password."', 
											emailAddress = '".$emailAddress."'
									WHERE 
											id = ?", [''.$loggedInUser.'']);

		/* userphonedetails table */

		/* Phons */

		if($data['phoneNumber'] != $phoneNumbers[0]->phoneNumber){
			$phoneNumber = $data['phoneNumber'];
		}
		else{
			$phoneNumber = $phoneNumbers[0]->phoneNumber;
		}

		if(isset($data['altphoneNumber']))
		{
			$altphoneNumber = $data['altphoneNumber'];
		}
		else{
			$altphoneNumber = $phoneNumbers[1]->phoneNumber;
		}
		
		$result = app('db')->update("UPDATE `userphonedetails` SET 
											phoneNumber = '".$phoneNumber."'
									WHERE 
											user_id = ? AND isPrimary = 'Y'", [''.$loggedInUser.'']);

		$result = app('db')->update("UPDATE `userphonedetails` SET 
											phoneNumber = '".$altphoneNumber."'
									WHERE 
											user_id = ? AND isPrimary = 'N'", [''.$loggedInUser.'']);

		
		/* userlanguages table */
        $language = '';

        if($data['language'] != $profileData[0]->languageID){
			$language = $data['language'];
		}
		else{
			$language = $profileData[0]->languageID;
		}

		$result = app('db')->update("UPDATE `userlanguages` SET 
											languageID = '".$language."'
									WHERE 
											user_id = ?", [''.$loggedInUser.'']);


		/* 	userskills table */
     	
     	if($data['skills'] != $existingSkills){
			$skillArray = explode(',', $data['skills']);
		}
		else{
			$skillArray = explode(',', $existingSkills);
		}

		/* Skills */
		
		if(!empty($skillArray))
		{
			foreach($skillArray as $key=>$skillID)
			{
				if($skillID > 0)
				{
					$result = app('db')->update("UPDATE `userskills` SET 
											deleted_at = '".$modifiedDateTime."'
									WHERE 
											user_id = ? ", [''.$loggedInUser.'']);
					
				
					$result = app('db')->insert("INSERT INTO `userskills` (user_id, skillID) 
										VALUES (?,?)", 
										[''.$loggedInUser.'', ''.$skillID.'']
										);
				}
			}
		}

		
		/* Profile Links */

		if(isset($data['InstagramLink']))
	    {
	    	$profileLinks[1] = $data['InstagramLink'];
	    }
	    if(isset($data['FacebookLink']))
	    {
	    	$profileLinks[2] = $data['FacebookLink'];
	    }
	    if(isset($data['TwitterLink']))
	    {
	    	$profileLinks[3] = $data['TwitterLink'];
	    }
	    if(isset($data['YoutubeLink']))
	    {
	    	$profileLinks[4] = $data['YoutubeLink'];
	    }
	    if(isset($data['GithubLink']))
	    {
	    	$profileLinks[5] = $data['GithubLink'];
	    }


	    if($data['InstagramLink'] != $userSocialLinks[0]->socialProfile){
			$profileLinks[1] = $data['InstagramLink'];
		}
		else{
			$profileLinks[1] = $userSocialLinks[0]->socialProfile;
		}


		if($data['FacebookLink'] != $userSocialLinks[1]->socialProfile){
			$profileLinks[2] = $data['FacebookLink'];
		}
		else{
			$profileLinks[2] = $userSocialLinks[1]->socialProfile;
		}

		if($data['TwitterLink'] != $userSocialLinks[2]->socialProfile){
			$profileLinks[3] = $data['TwitterLink'];
		}
		else{
			$profileLinks[3] = $userSocialLinks[2]->socialProfile;
		}

		if($data['YoutubeLink'] != $userSocialLinks[3]->socialProfile){
			$profileLinks[4] = $data['YoutubeLink'];
		}
		else{
			$profileLinks[4] = $userSocialLinks[3]->socialProfile;
		}
		if($data['GithubLink'] != $userSocialLinks[4]->socialProfile){
			$profileLinks[5] = $data['GithubLink'];
		}
		else{
			$profileLinks[5] = $userSocialLinks[4]->socialProfile;
		}

		if(!empty($profileLinks))
		{
			$result = app('db')->update("DELETE FROM `usersocialprofilelinks` 
									WHERE 
										user_id = ?", [''.$loggedInUser.'']);
		}

		/* profile links */
		foreach($profileLinks as $key=>$profileValue)
		{
			$result = app('db')->insert("INSERT INTO `usersocialprofilelinks` (user_id, socialProfileID , socialProfile) 
									VALUES (?,?, ?)", 
									[''.$loggedInUser.'', ''.$key.'', ''.$profileValue.'']
									);
		}


		/* Professional exp */

		if($data['fromDate1'] != $professionalExp[0]->fromDate){
			$fromDate1 = substr($data['fromDate1'],4,11);
			$fromDate1 = date('Y-m-d', strtotime($fromDate1));
		}
		else{
			$fromDate1 = $professionalExp[0]->fromDate;
		}

		if($data['toDate1'] != $professionalExp[0]->toDate){
			$toDate1 = substr($data['toDate1'],4,11);
			$toDate1 = date('Y-m-d', strtotime($toDate1));

		}
		else{
			$toDate1 = $professionalExp[0]->toDate;
		}

		if($data['ddlCompany1'] != $professionalExp[0]->companyName){
			$ddlCompany1 = $data['ddlCompany1'];
		}
		else{
			$ddlCompany1 = $professionalExp[0]->companyName;
		}

		if($data['ddlPosition1'] != $professionalExp[0]->positionName){
			$ddlPosition1 = $data['ddlPosition1'];
		}
		else{
			$ddlPosition1 = $professionalExp[0]->positionName;
		}


		if($data['ddlCompany1'] != 'undefined'){
			$ddlCompany1 = $data['ddlCompany1'];
		}
		else{
			$ddlCompany1 = $professionalExp[0]->companyName;
		}

		if($data['ddlPosition1'] != 'undefined'){
			$ddlPosition1 = $data['ddlPosition1'];
		}
		else{
			$ddlPosition1 = $professionalExp[0]->positionName;
		}



		$result = app('db')->update("UPDATE `userprofessionalexperience` SET 
											fromDate = '".$fromDate1."',
											toDate = '".$toDate1."',
											companyName = '".$ddlCompany1."',
											positionName = '".$ddlPosition1."'
									WHERE 
											user_id = ?", [''.$loggedInUser.'']);


	/* User Resume Path */		
		if(!empty($userResumes))
		{
			if($data['resumeFilePath'] != $userResumes[0]->resumePath){
				$resumeFilePath = $data['resumeFilePath'];
			}
			else{
				$resumeFilePath = $userResumes[0]->resumePath;
			}

			if($data['resumeFileNewName'] != $userResumes[0]->resumeName){
				$resumeFileNewName = $data['resumeFileNewName'];
			}
			else{
				$resumeFileNewName = $userResumes[0]->resumeName;
			}
		}
		else{

			$resumeFilePath = $data['resumeFilePath'];
			$resumeFileNewName = $data['resumeFileNewName'];
		}

		if(!empty($resumeFilePath))
		{
			$result = app('db')->update("UPDATE `userresumedetails` SET 
											deleted_at = '".$modifiedDateTime."'
									WHERE 
											user_id = ?", [''.$loggedInUser.'']);
		}
		$result = app('db')->insert("INSERT INTO `userresumedetails` (user_id, resumePath, resumeName) VALUES (?,?,?)", 
									[''.$loggedInUser.'', ''.$resumeFilePath.'' , ''.$resumeFileNewName.'']
									);


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

	public function verifyLogin($data)
	{
		$userName = '';
		$password = '';

		if($data['emailAddress']!='')
		{
			$userName = $data['emailAddress'];
		}
		if($data['password']!='')
		{
			$password = md5($data['password']);
		}
		if($data['role_id']!='')
		{
			$role_id = md5($data['role_id']);
		}
		
		$role_id = 3;

		$employeeStatus	 = app('db')->select("SELECT 
												a.id,
												a.user_id,
												a.role_id
										 FROM users as a  
                                          WHERE 
                                          	a.emailAddress = ? AND a.role_id = ? AND `status` = 'A' " , [''.$userName.'' , ''.$role_id.'']);
		if(count($employeeStatus) == 0)
		{
			$returnMessage['msg'] = 'fail';
			$returnMessage['returnMessage'] = 'Your profile was not activated yet. Please check your email and active the profile.';
		    return $returnMessage;
		}
		else {
			$returnMessage['msg'] = 'success';
			$returnMessage['returnMessage'] = 'Thank you. Your login credentials are correct! Please wait ...';
			$returnMessage['data'] =  $employeeStatus;
		
		    return $returnMessage;
		}





	}

	public function verifyUserName($data)
	{
		$userName = '';
		$password = '';

		if($data['username']!='')
		{
			$userName = $data['username'];
		}
		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM jobseekerprofiles as a  
                                          WHERE 
                                          	a.userName = ? " , [''.$userName.'']);
		
		return $employees;


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
                                          	a.emailAddress = ? AND role_id = 2 " , [''.$emailAddress.'']);
		
		return $employees;


	}
	public function verifyPhoneName($data)
	{

		if($data['phoneNumber']!='')
		{
			$phoneNumber = $data['phoneNumber'];
		}
		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM userphonedetails as a  
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
                                          	a.emailAddress = ? AND  id <> ? AND role_id = 2 " , [''.$emailAddress.'' , ''.$employeeID.'']);
		
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
										 FROM userphonedetails as a  
                                          WHERE 
                                          	a.phoneNumber = ? AND user_id <> ?" , [''.$phoneNumber.'', ''.$employeeID.'']);
		
		return $employees;


	}


	public function verifyEmployeeEmail($data)
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

	public function verifyEmployeeEmailForEdit($data)
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

	public function verifyEmployeePhoneName($data)
	{

		if($data['phoneNumber']!='')
		{
			$phoneNumber = $data['phoneNumber'];
		}
		$employees	 = app('db')->select("SELECT 
												a.id
										 FROM employees as a  
                                          WHERE 
                                          	a.phoneNumber = ? " , [''.$phoneNumber.'']);
		
		return $employees;
	}

	public function activate($data)
	{

		$activationCode = '';
		$activationString = '';

		if(isset($data['activationCode']))
		{
			$activationCode = $data['activationCode'];
		}

		if(isset($data['activationString']))
		{
			$activationString = $data['activationString'];
		}

		$employees	 = app('db')->select("SELECT 
												count(*) as Num
										 FROM 
										 		users as a  
                                          WHERE 
                                          	a.randomCode = ?  AND a.randomString = ? " , [''.$activationCode.'' , ''.$activationString.'']);

		if(!empty($employees))
		{
			$count = $employees[0]->Num;

		}

		if($count == 0)
		{
			$returnMessage['msg'] = 'fail';
		    return $returnMessage;
		}
		else{

			$updateRes	 = app('db')->update("UPDATE  
												users 
											 SET `status` = 'A'
                                          WHERE 
                                          	randomCode = ?  AND randomString = ? " , [''.$activationCode.'' , ''.$activationString.'']);
			$returnMessage['msg'] = 'success';
		    return $returnMessage;

		}
	}

	public function forgotPassWord($data)
	{

		$emailAccount = '';


		if(isset($data['emailAccount']))
		{
			$emailAccount = $data['emailAccount'];
		}


		$employees	 = app('db')->select("SELECT 
												a.id,
												a.user_id,
												b.companyName
										 FROM 
										 		users as a  
										 	JOIN
										 		companyprofiles  as b 
										 	ON
										 		b.id = a.user_id
                                          WHERE 
                                          	a.emailAddress = ? " , [''.$emailAccount.'']);
		$count = count($employees);

		if($count == 0)
		{
			$returnMessage['msg'] = 'fail';
		    return $returnMessage;
		}
		else{

			$user_id = $employees[0]->user_id;
			$randomString = Str::random();
			$randomCode = substr(rand(), 0,4);
			$companyName = $employees[0]->companyName;

			$result = app('db')->insert("INSERT INTO `forgotpassword` (user_id, randomCode, randomString) 
									VALUES (?,?,?)", 
									[''.$user_id.'', ''.$randomCode.'', ''.$randomString.'']
									);

			
			$this->sendEmail($companyName , $emailAccount , $randomCode , $randomString);

			$returnMessage['msg'] = 'success';
			return $returnMessage;

		}
		

	}

	public function sendEmail($companyName , $emailAddress , $randomCode , $randomString) {
        $fhEmail = new fh();
        $fhEmail->link = 'http://facehiring.com/updatePassword/'.$randomString;
        $fhEmail->subject = $companyName.', your pin is '.$randomCode.'. Please change your password';
        $fhEmail->name = $companyName;
        $fhEmail->activationCode = $randomCode;
        $fhEmail->template = 'my-forgot-email';
        Mail::to($emailAddress, $companyName)->send($fhEmail);
    }


    public function modifyPassword($data)
	{

		$activationCode = '';
		$activationString = '';

		if(isset($data['activationCode']))
		{
			$activationCode = $data['activationCode'];
		}

		if(isset($data['activationString']))
		{
			$activationString = $data['activationString'];
		}

		if(isset($data['password']))
		{
			$password = md5($data['password']);
		}


		$employees	 = app('db')->select("SELECT 
												user_id
										 FROM 
										 		forgotpassword as a  
                                          WHERE 
                                          	a.randomCode = ?  AND a.randomString = ? " , [''.$activationCode.'' , ''.$activationString.'']);

		$count = count($employees);
		
		if($count == 0)
		{
			$returnMessage['msg'] = 'fail';
		    return $returnMessage;
		}
		else{

			$modifiedDateTime = date('Y-m-d h:i:s');
			$user_id = $employees[0]->user_id;

			$updateRes	 = app('db')->update("UPDATE  
												users 
											 SET `password` = ? , `updated_at` = ?
                                          WHERE 
                                          	user_id = ?  " , [''.$password.'' , ''.$modifiedDateTime.'', ''.$user_id.'']);
			$returnMessage['msg'] = 'success';
		    return $returnMessage;

		}
	}





}
