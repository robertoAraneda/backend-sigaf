<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});



/**routes para sincronizar la app de forma masiva (inicial) */
Route::get('/fetch/all', 'SynchronizeController@synchronizeAppInit');
Route::get('/fetch/all/platforms-categories', 'SynchronizeController@syncronizeAppPlatformsCategoriesDaily');
Route::get('/fetch/all/courses', 'SynchronizeController@synchronizeAppCoursesActive');
Route::get('/fetch/all/activities', 'SynchronizeController@syncronizeAppActivitiesActive');
Route::get('/fetch/all/user-registered', 'SynchronizeController@syncronizeAppRegisteredUsersActiveInit');
Route::get('/fetch/all/user-registered-activities', 'SynchronizeController@syncronizeAppRegisteredUserActivitiesActiveInit');


/** routes para sincronizar la app de forma manual (diaria) */
Route::get('/fetch/daily', 'SynchronizeController@syncronizeAppDaily');

Route::get('/fetch/daily/user-registered', 'SynchronizeController@syncronizeAppRegisteredUsersActive');
Route::get('/fetch/daily/user-registered-activities', 'SynchronizeController@syncronizeAppRegisteredUserActivitiesActive');


/**rutas api */

Route::apiResource('/final-status', 'FinalStatusController');
Route::apiResource('/type-ticket', 'TypeTicketController');
Route::apiResource('/motive-ticket', 'MotiveTicketController');
Route::apiResource('/priority-ticket', 'PriorityTicketController');
Route::apiResource('/profile', 'ProfileController');
Route::apiResource('/role', 'RoleController');
Route::apiResource('/status-detail-ticket', 'StatusDetailTicketController');
Route::apiResource('/status-ticket', 'StatusTicketController');
Route::apiResource('/classroom', 'ClassroomController');
Route::apiResource('/ticket-detail', 'TicketDetailController');
Route::apiResource('/ticket', 'TicketController');
Route::apiResource('/alert', 'AlertController');

/**rutas files */

Route::get('/upload-file/excel', 'RegisteredUserController@import');

Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');
  Route::post('signup', 'AuthController@signup');

  Route::group([
    'middleware' => 'auth:api'
  ], function () {
    Route::get('user', 'AuthController@user');
    Route::get('logout', 'AuthController@logout');
  });
});

Route::group([
  'prefix' => 'v2',
  'middleware' => 'auth:api'
], function () {
  Route::apiResource('/type-tickets', 'TypeTicketController')->names('api.typeTickets');

  Route::apiResource('/activities', 'ActivityController')->names('api.activities');

  Route::apiResource('/status-ticket', 'StatusTicketController');
  Route::apiResource('/alert', 'AlertController');
  Route::get('/course-registered-user', 'CourseRegisteredUserController@index');
  Route::get('/courses', 'CourseController@index');
  Route::get('/registered-user/{rut}', 'RegisteredUserController@findByRut');
  Route::apiResource('/tickets', 'TicketController');
  Route::get('/activity-course-registered-user/{id}', 'ActivityCourseRegisteredUserController@findByIdRegisteredUserCourse');

  //rels
  Route::get('/type-tickets/{type_ticket}/tickets', 'TypeTicketController@tickets')->name('api.typeTickets.tickets');
  Route::get('/activities/{activity}/activity-course-registered-users', 'ActivityController@activityCourseRegisteredUsers')->name('api.activities.activityCourseRegisteredUsers');
});
