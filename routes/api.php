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
  Route::apiResource('/alerts', 'AlertController')->names('api.alerts');
  Route::apiResource('/categories', 'CategoryController')->names('api.categories');
  Route::apiResource('/courses', 'CourseController')->names('api.courses');
  Route::apiResource('/platforms', 'PlatformController')->names('api.platforms');
  Route::apiResource('/tickets', 'TicketController')->names('api.tickets');
  Route::apiResource('/activity-course-users', 'ActivityCourseRegisteredUserController')->names('api.activityCourseUsers');
  Route::apiResource('/course-registered-users', 'CourseRegisteredUserController')->names('api.courseRegisteredUsers');
  Route::apiResource('/registered-users', 'RegisteredUserController')->names('api.registeredUsers');




  Route::apiResource('/status-ticket', 'StatusTicketController');

  Route::get('/registered-user/{rut}', 'RegisteredUserController@findByRut');
  Route::get('/activity-course-registered-user/{id}', 'ActivityCourseRegisteredUserController@findByIdRegisteredUserCourse');


  //rels
  Route::get('/type-tickets/{type_ticket}/tickets', 'TypeTicketController@tickets')->name('api.typeTickets.tickets');
  Route::get('/activities/{activity}/activity-course-users', 'ActivityController@activityCourseUsers')->name('api.activities.activityCourseUsers');
  Route::get('/categories/{category}/courses', 'CategoryController@courses')->name('api.categories.courses');

  Route::get('/courses/{course}/activities', 'CourseController@activities')->name('api.courses.activities');
  Route::get('/courses/{course}/registered-users', 'CourseController@registeredUsers')->name('api.courses.registeredUsers');
  Route::get('/courses/{course}/registered-users/{registered_user}', 'CourseController@registeredUser')->name('api.courses.registeredUsers.show');
  Route::get('/courses/{course}/registered-users/{registered_user}/activities', 'CourseController@userActivities')->name('api.courses.registeredUsers.activities');


  Route::get('/course-users/{course_user}/activities', 'CourseRegisteredUserController@activities')->name('api.courseRegisteredUsers.activities');
  Route::get('/platforms/{platform}/categories', 'PlatformController@categories')->name('api.platforms.categories');

  Route::get('/registered-users/{registered_user}/courses', 'RegisteredUserController@courses')->name('api.registeredUsers.courses');
  Route::get('/registered-users/{registered_user}/courses/{course}', 'RegisteredUserController@course')->name('api.registeredUsers.courses.show');
  Route::get('/registered-users/{registered_user}/courses/{course}/activities', 'RegisteredUserController@activities')->name('api.registeredUsers.activities');

  Route::get('/registered-users/{registered_user}/tickets', 'RegisteredUserController@tickets')->name('api.registeredUsers.tickets');
});
