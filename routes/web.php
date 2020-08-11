<?php

use Illuminate\Http\Request;
use App\Services\Factory\Route\RouteServiceFactory;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['middleware' => 'jwt-auth:api'], function($app)
{
    $app->get('/test', function() {
        return response()->json([
            'message' => 'Hello World!',
        ]);
    });

    // $app->get('locations', 'common\LocationController@index');
    $app->post('getAuthenticationUser', 'AuthController@getAuthenticatedUser');

});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('login', 'AuthController@postLogin');


$router->get('locations', 'common\LocationController@index');
$router->get('companies', 'common\CompaniesController@index');
$router->get('jobPositions', 'common\JobPositionController@index');
$router->get('skills', 'common\SkillController@index');
$router->get('genders', 'common\GenderController@index');
$router->get('languages', 'common\LanguageController@index');


$router->post('register', 'profiles\UserRegisterController@index');
$router->post('edit', 	  'profiles\UserRegisterController@editProfile');

$router->post('getEmployeeProfile', 'profiles\EmployeeController@getEmployeeInfo');
$router->post('verifyLogin', 'profiles\UserRegisterController@verifyLogin');
$router->post('activate', 'profiles\UserRegisterController@activate');
$router->post('forgotPassWord', 'profiles\UserRegisterController@forgotPassWord');
$router->post('modifyPassword', 'profiles\UserRegisterController@modifyPassword');


$router->post('verifyUserName', 'profiles\UserRegisterController@verifyUserName');
$router->post('verifyPhoneName', 'profiles\UserRegisterController@verifyPhoneName');
$router->post('verifyEmail', 'profiles\UserRegisterController@verifyEmail');
$router->post('verifyPhoneNameEdit', 'profiles\UserRegisterController@verifyPhoneNameEdit');
$router->post('verifyEmailForEdit', 'profiles\UserRegisterController@verifyEmailForEdit');

$router->post('getEmployeeHomDetails', 'profiles\EmployeeController@getEmployeeHomDetails');
$router->post('getPeopleWhoMayKnow', 'profiles\EmployeeController@getPeopleWhoMayKnow');
$router->post('getEmployeeHomePics', 'profiles\EmployeeController@getEmployeeHomePics');

$router->post('uploadHomePageFileL', 'profiles\EmployeeController@uploadHomePageFileL');
$router->post('uploadHomePageFileR', 'profiles\EmployeeController@uploadHomePageFileR');

$router->post('getPosts', 'profiles\EmployeeController@getPosts');
$router->post('pushComments', 'profiles\EmployeeController@pushComments');
$router->post('pushPost', 'profiles\EmployeeController@pushPost');
$router->post('postImage', 'profiles\EmployeeController@postImage');
$router->post('postSharing', 'profiles\EmployeeController@postSharing');
$router->post('postLike', 'profiles\EmployeeController@postLike');

$router->post('getConnectPeople', 'profiles\EmployeeController@getConnectPeople');
$router->post('connectme', 'profiles\EmployeeController@connectme');
$router->post('getPendingRequests', 'profiles\EmployeeController@getPendingRequests');
$router->post('acceptRequest', 'profiles\EmployeeController@acceptRequest');
$router->post('followMe', 'profiles\EmployeeController@followMe');

$router->post('gettotalConnects', 'profiles\EmployeeController@gettotalConnects');
$router->post('addGroup', 'profiles\EmployeeController@addGroup');
$router->post('gettotalGroups', 'profiles\EmployeeController@gettotalGroups');
$router->post('addMeToGroup', 'profiles\EmployeeController@addMeToGroup');

$router->post('addHashTag', 'profiles\EmployeeController@addHashTag');
$router->post('verifyHashTag', 'profiles\EmployeeController@verifyHashTag');

$router->get('sendemail', 'profiles\HRcontroller@sendEmail');
$router->post('changePassword', 'profiles\HRcontroller@changePassword');


$router->group(['prefix' => 'Employee'], function() use ($router)
{
    $router->post('register', 'profiles\HRcontroller@employeeRegister');
    $router->post('getHRProfile', 'profiles\HRcontroller@getHRProfile');
    $router->post('getCompanyProfile', 'profiles\HRcontroller@getCompanyProfile');
    $router->post('editHRProfile', 'profiles\HRcontroller@editHRProfile');
    $router->post('verifyEmail', 'profiles\HRcontroller@verifyEmail');
    $router->post('verifyEmailForEdit', 'profiles\HRcontroller@verifyEmailForEdit');
    $router->post('getSimilarProfiles', 'profiles\HRcontroller@getSimilarProfiles');
    $router->post('getComopanyUpdates', 'profiles\HRcontroller@getComopanyUpdates');
    $router->post('pushUpdates', 'profiles\HRcontroller@pushUpdates');
    $router->post('getCompanyCareers', 'profiles\HRcontroller@getCompanyCareers');
    $router->post('pushCareer', 'profiles\HRcontroller@pushCareer');
    $router->post('uploadHomePageFileL', 'profiles\HRcontroller@uploadHomePageFileL');
    $router->get('random', 'profiles\HRcontroller@random');
    $router->post('submitJobPost', 'profiles\HRcontroller@submitJobPost');
    $router->post('getJobPostings', 'profiles\HRcontroller@getJobPostings');
    $router->post('statusChange', 'profiles\HRcontroller@statusChange');
    $router->post('getJobPostingByID', 'profiles\HRcontroller@getJobPostingByID');
    $router->post('editJobPost', 'profiles\HRcontroller@editJobPost');
    $router->post('getActiveJobs', 'profiles\HRcontroller@getActiveJobs');

    
});
/*
$router->group(
            ['prefix' => 'services'],
            function () {
            $router->get('locations', ['uses' => 'LocationController@getLocations'])->name('services.locations');
            });
*/