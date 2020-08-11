<?php

namespace App\models\profiles;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //

    public function getEmployeeInfo($data)
	{
		$employeeID = $data['employeeID'];
		$employees	 = app('db')->select("SELECT 
												a.firstName, 
												a.lastName,
												a.userName,
												a.password,
												a.dob,
												a.emailAddress,
												a.about,
												a.organization,
												a.website,
												a.gender,
												a.locationID,
												a.imageProfile,
                                                b.locationName as 'locationName',
                                                c.languageID
										 FROM users as a  
                                         JOIN	
                                         	locations as b 
                                          ON	
                                          	a.locationID = b.id
                                          JOIN
                                          	userlanguages c 
                                           ON
                                           	a.id = c.user_id
                                          WHERE 
                                          	a.id = ? " , [''.$employeeID.'']);

		return $employees;
	}

	public function getEmployeePhoneNumbers($data)
	{
		$employeeID = $data['employeeID'];

		$employeePhones	 = app('db')->select(" 
											SELECT 
												phoneNumber, 
												isPrimary 
											FROM 
												`userphonedetails`
											WHERE
                                          		user_id = ? " , [''.$employeeID.'']);

		return $employeePhones;


	}

	public function getProfessionalExp($data)
	{

		$employeeID = $data['employeeID'];

		$employeExp	 = app('db')->select(" 
											SELECT 
												a.fromDate,
											    a.toDate,
											    a.companyName,
											    a.positionName
											   FROM 
											   	`userprofessionalexperience` a 
											    WHERE a.user_id = ? " , [''.$employeeID.'']);

		return $employeExp;

	}

	public function getSkills($data)
	{
		$employeeID = $data['employeeID'];
		$employeeSkills	 = app('db')->select(" 
											SELECT 
												a.skillID as 'id',
											    b.skillName as 'itemName'
											FROM 
												   	`userskills` a 
											JOIN	
													`jobskills` b 
											ON
												 a.skillID = b.id
											     
											WHERE a.user_id =  ? AND a.deleted_at IS NULL" , [''.$employeeID.'']);

		return $employeeSkills;
	}

	public function getResumes($data)
	{
		$employeeID = $data['employeeID'];
		$employeeResumes	 = app('db')->select(" 
											SELECT 
												a.resumePath,
												a.resumeName
											FROM 
												   	`userresumedetails` a 
											WHERE a.user_id =  ? AND deleted_at IS NULL " , [''.$employeeID.'']);

		return $employeeResumes;
	}

	public function getSocialLinks($data)
	{
		$employeeID = $data['employeeID'];
		$employeeSocialLinks	 = app('db')->select(" 
											SELECT 
												a.socialProfileID,
												a.socialProfile
											FROM 
												   	`usersocialprofilelinks` a 
											WHERE a.user_id =  ? " , [''.$employeeID.'']);

		return $employeeSocialLinks;

	}

	public function getEmployeeHomDetails($data)
	{

		$employeeID = $data['employeeID'];

		$employeeHome	 = app('db')->select(" 
											SELECT 
												a.firstName,
											    a.lastName,
											    CASE 
													WHEN IFNULL(a.imageProfile,'') <>'' 
													THEN a.imageProfile 
													ELSE 'assets/files/profilePics/blank.png' 
												END 'imageProfile',
											    b.positionName,
											    b.companyName
											FROM
											    users a 
											LEFT JOIN 
												userprofessionalexperience b 
											 ON 
											 	a.id = b.user_id
											WHERE 
											    a.id = ? 
											order by 
												b.toDate DESC
											LIMIT 0,1    " , [''.$employeeID.'']);

		return $employeeHome;

	}

	public function peopleMayKnow($data)
	{

		$employeeID = $data['employeeID'];

		$peopleMayKnow	 = app('db')->select(" 
											SELECT 
												a.id,
												a.firstName, 
												a.lastName, 
												CASE 
													WHEN IFNULL(a.imageProfile,'') <>'' 
													THEN a.imageProfile 
													ELSE 'assets/files/profilePics/blank.png' 
												END 'imageProfile',

												t1.positionName, 
												t1.companyName
											FROM 
												userprofessionalexperience t1
											JOIN 
												users a 
											ON 
												a.id = t1.user_id
											WHERE 
												t1.updated_at = (SELECT MAX(t2.updated_at)
											                 FROM userprofessionalexperience t2
											                 WHERE t2.user_id = t1.user_id)
											AND 
												a.id <> ? " , [''.$employeeID.'']);

		return $peopleMayKnow;

	}

	public function getEmployeeHomePics($data)
	{

		$employeeID = $data['employeeID'];

		$employeeHomePics	 = app('db')->select(" 
											SELECT 
												CASE 
													WHEN IFNULL(leftsideimagepath,'') <>'' 
													THEN leftsideimagepath 
													ELSE 'assets/files/profilePics/default.png' 
													END 'leftsideimagepath', 
												CASE
													WHEN IFNULL(rightsideimagepath,'') <> '' 
													THEN rightsideimagepath 
													ELSE 'assets/files/profilePics/default.png' 
													END 'rightsideimagepath' 
													FROM 
														`userhomepageimages`
										     		WHERE 
										     			user_id = ? " , [''.$employeeID.'']);

		return $employeeHomePics;
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


		$result = app('db')->update("UPDATE `userhomepageimages` SET 
											leftsideimagepath = '".$leftsideimagepath."',
											updated_at = '".$modifiedDateTime."'
									WHERE 
											user_id = ? ", [''.$loggedInUser.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function uploadHomePageFileR($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		$rightsideimagepath = '';
		$loggedInUser = '';

		if(isset($data['profilePicPath']))
		{
			$rightsideimagepath = $data['profilePicPath'];
		}

		if(isset($data['loggedInUser']))
		{
			$loggedInUser = $data['loggedInUser'];
		}


		$result = app('db')->update("UPDATE `userhomepageimages` SET 
											rightsideimagepath = '".$rightsideimagepath."',
											updated_at = '".$modifiedDateTime."'
									WHERE 
											user_id = ? ", [''.$loggedInUser.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function getPosts($data)
	{

		$employeeID = $data['employeeID'];

		$posts	 = app('db')->select(" 
											SELECT 
												a.id,
											    a.user_id,
											    a.post,
											    a.created_at,
											    a.type,
											    b.firstName,
											    b.lastName,
											    CASE 
													WHEN IFNULL(b.imageProfile,'') <>'' 
													THEN b.imageProfile 
													ELSE 'assets/files/profilePics/blank.png' 
												END 'imageProfile',

											    t1.positionName, 
												t1.companyName
											 FROM 
											    posts a 
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
											  ORDER BY a.created_at DESC " );

		return $posts;

	}

	public function pushComments($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['postID']))
		{
			$postID = $data['postID'];
		}
		if(isset($data['commentNotes']))
		{
			$commentNotes = $data['commentNotes'];
		}


		$result = app('db')->insert("INSERT INTO `postcomments` (user_id, post_id, comments) 
									VALUES (?,?,?)", 
									[''.$employeeID.'', ''.$postID.'',''.$commentNotes.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function pushPost($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['commentNotes']))
		{
			$commentNotes = $data['commentNotes'];
		}


		$result = app('db')->insert("INSERT INTO `posts` (user_id, post, type) 
									VALUES (?,?,?)", 
									[''.$employeeID.'', ''.$commentNotes.'', 'text']
									);

		
		$returnMessage['msg'] = 'success';
		return $returnMessage;

		
	}

	public function postImage($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['loggedInUser']))
		{
			$employeeID = $data['loggedInUser'];
		}

		if(isset($data['profilePicPath']))
		{
			$profilePicPath = $data['profilePicPath'];
		}


		$result = app('db')->insert("INSERT INTO `posts` (user_id, post, type) 
									VALUES (?,?,?)", 
									[''.$employeeID.'', ''.$profilePicPath.'', 'image']
									);

		
		$returnMessage['msg'] = 'success';
		return $returnMessage;

		
	}

	public function postSharing($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['postID']))
		{
			$postID = $data['postID'];
		}


		$result = app('db')->insert("INSERT INTO `postsharing` (user_id, post_id) 
									VALUES (?,?)", 
									[''.$employeeID.'', ''.$postID.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function postLike($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['postID']))
		{
			$postID = $data['postID'];
		}


		$result = app('db')->insert("INSERT INTO `postlikes` (user_id, post_id) 
									VALUES (?,?)", 
									[''.$employeeID.'', ''.$postID.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}



	public function getConnectPeople($data)
	{
		$employeeID = $data['employeeID'];
		$connectPeople	 = app('db')->select("CALL ".env('DB_DATABASE').".sp_connects (".$employeeID.")");
		return $connectPeople;
	}

	public function getPendingRequests($data)
	{
		$employeeID = $data['employeeID'];
		$connectPeople	 = app('db')->select("SELECT 
												a.id as 'connectID',
												a.connect_id,
											    a.user_id,
											    CONCAT(e1.firstName,' ',e1.lastName) as 'yourName',
											    CONCAT(e2.firstName,' ',e2.lastName) as 'myName',
											     e2.imageProfile
											FROM
												`userconnects` a 
											JOIN	
												users e1 
											 ON 
											 	a.connect_id = e1.id 
											 JOIN 
											 	users e2 
											 ON  
											 	a.user_id = e2.id
											WHERE 
												a.connect_id = (?) 
											 AND 
											 	a.deleted_at IS NULL 
											 AND 
											 	a.status = 'P' ", [''.$employeeID.'']);
		return $connectPeople;
	}


	public function connectme($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['connect_id']))
		{
			$connect_id = $data['connect_id'];
		}

		$result = app('db')->update("UPDATE `userconnects` SET 
											deleted_at = '".$modifiedDateTime."'
									WHERE 
											user_id = ? AND connect_id = ? ", [''.$employeeID.'' , ''.$connect_id.'']);

		$result = app('db')->insert("INSERT INTO `userconnects` (user_id, connect_id, status) 
									VALUES (?,?,?)", 
									[''.$employeeID.'', ''.$connect_id.'', 'P']
									);

		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}
	

	public function acceptRequest($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');

		if(isset($data['connectID']))
		{
			$connectID = $data['connectID'];
		}

		$result = app('db')->update("UPDATE `userconnects` SET 
											status = 'A',
											updated_at = '".$modifiedDateTime."'
									WHERE 
											id = ? ", [''.$connectID.'']);
		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}


	public function followMe($data)
	{
		$modifiedDateTime = date('Y-m-d h:i:s');
		

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['follower_id']))
		{
			$follower_id = $data['follower_id'];
		}

		$result = app('db')->insert("INSERT INTO `userfollowers` (user_id, follower_id, status) 
									VALUES (?,?,?)", 
									[''.$employeeID.'', ''.$follower_id.'', 'A']
									);

		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function gettotalConnects($data)
	{
		$employeeID = $data['employeeID'];
		$connectPeople	 = app('db')->select("CALL ".env('DB_DATABASE').".sp_gettotalconnectsByEmployee (".$employeeID.")");
		return $connectPeople;
	}

	public function addGroup($data)
	{
	

		if(isset($data['loggedInEmployeeID']))
		{
			$employeeID = $data['loggedInEmployeeID'];
		}

		if(isset($data['addForm']))
		{
			$addForm = $data['addForm'];
		}


		$result = app('db')->insert("INSERT INTO `usergroups` (groupName, created_by) 
									VALUES (?,?)", 
									[''.$addForm.'', ''.$employeeID.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function gettotalGroups($data)
	{
		$employeeID = $data['employeeID'];
		$groups	 = app('db')->select("CALL ".env('DB_DATABASE').".sp_getUserGroups (".$employeeID.")");
		return $groups;
	}

	public function addMeToGroup($data)
	{
	

		if(isset($data['employeeID']))
		{
			$employeeID = $data['employeeID'];
		}

		if(isset($data['group_id']))
		{
			$group_id = $data['group_id'];
		}


		$result = app('db')->insert("INSERT INTO `usergroupconnections` (usergroup_id, user_id) 
									VALUES (?,?)", 
									[''.$group_id.'', ''.$employeeID.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function addHashTag($data)
	{
	

		if(isset($data['loggedInEmployeeID']))
		{
			$employeeID = $data['loggedInEmployeeID'];
		}

		if(isset($data['hashTag']))
		{
			$hashTag = $data['hashTag'];
		}
		$result = app('db')->insert("INSERT INTO `userhastags` (hashtagName, created_by) 
									VALUES (?,?)", 
									[''.$hashTag.'', ''.$employeeID.'']
									);


		$returnMessage['msg'] = 'success';
		return $returnMessage;
	}

	public function verifyHashTag($data)
	{
	

		if(isset($data['hashTagValue']))
		{
			$hashTagValue = $data['hashTagValue'];
		}

		$result = app('db')->select(" SELECT id FROM userhastags WHERE hashtagName = (?) ", [''.$hashTagValue.'']);
		return $result;

	}


}