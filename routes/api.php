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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });



/**routes para sincronizar la app de forma masiva (inicial) */
Route::get('/fetch/all', 'SynchronizeController@synchronizeAppInit')->name('sync.all');
Route::get('/fetch/all/platforms-categories', 'SynchronizeController@syncronizeAppPlatformsCategoriesDaily')->name('sync.platforms');
Route::get('/fetch/all/courses', 'SynchronizeController@synchronizeAppCoursesActive')->name('sync.courses');
Route::get('/fetch/all/activities', 'SynchronizeController@syncronizeAppActivitiesActive')->name('sync.activities');
Route::get('/fetch/all/user-registered', 'SynchronizeController@syncronizeAppRegisteredUsersActiveInit')->name('sync.users');
Route::get('/fetch/all/user-registered-activities', 'SynchronizeController@syncronizeAppRegisteredUserActivitiesActiveInit')->name('sync.usersActivities');


/** routes para sincronizar la app de forma manual (diaria) */
Route::get('/fetch/daily', 'SynchronizeController@syncronizeAppDaily')->name('sync.daily.all');

Route::get('/fetch/daily/user-registered', 'SynchronizeController@syncronizeAppRegisteredUsersActive')->name('sync.daily.users');
Route::get('/fetch/daily/user-registered-activities', 'SynchronizeController@syncronizeAppRegisteredUserActivitiesActive')->name('sync.daily.usersActivities');

//optimización de consultas api moodle

Route::get('/fetch/course-users/{idCourseMoodle}/users', 'SynchronizeController@syncUsersByCourse');







/**rutas api */

// Route::apiResource('/final-status', 'FinalStatusController');
// Route::apiResource('/type-ticket', 'TypeTicketController');
// Route::apiResource('/motive-ticket', 'MotiveTicketController');
// Route::apiResource('/priority-ticket', 'PriorityTicketController');
// Route::apiResource('/profile', 'ProfileController');
// Route::apiResource('/role', 'RoleController');
// Route::apiResource('/status-detail-ticket', 'StatusDetailTicketController');
// Route::apiResource('/status-ticket', 'StatusTicketController');
// Route::apiResource('/classroom', 'ClassroomController');
// Route::apiResource('/ticket-detail', 'TicketDetailController');
// Route::apiResource('/ticket', 'TicketController');
// Route::apiResource('/alert', 'AlertController');

/**rutas files */




Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');

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
  Route::apiResource('/status-tickets', 'StatusTicketController')->names('api.statusTickets');
  Route::apiResource('/priority-tickets', 'PriorityTicketController')->names('api.priorityTickets');
  Route::apiResource('/motive-tickets', 'MotiveTicketController')->names('api.motiveTickets');
  Route::apiResource('/final-statuses', 'FinalStatusController')->names('api.finalStatuses');
  Route::apiResource('/classrooms', 'ClassroomController')->names('api.classrooms');
  Route::apiResource('/roles', 'RoleController')->names('api.roles');
  Route::apiResource('/source-tickets', 'SourceTicketController')->names('api.sourceTickets');
  Route::apiResource('/profiles', 'ProfileController')->names('api.profiles');
  Route::apiResource('/sections', 'SectionController')->names('api.sections');
  Route::apiResource('/users', 'UserController')->names('api.users');
  Route::apiResource('/status-detail-tickets', 'StatusDetailTicketController')->names('api.statusDetailTickets');
  Route::apiResource('/ticket-details', 'TicketDetailController')->names('api.ticketDetails');


  Route::get('/activity-course-registered-users/{activity_course_registered_user}', 'ActivityCourseRegisteredUserController@show')->name('api.activityCourseRegisteredUsers.show');

  Route::get('/course-registered-user', 'CourseRegisteredUserController@index');
  Route::apiResource('/activity-course-users', 'ActivityCourseRegisteredUserController')->names('api.activityCourseUsers');
  Route::apiResource('/course-registered-users', 'CourseRegisteredUserController')->names('api.courseRegisteredUsers');
  Route::apiResource('/registered-users', 'RegisteredUserController')->names('api.registeredUsers');

  Route::post('/users/signup', 'AuthController@signup');

  Route::get('/registered-user/{rut}', 'RegisteredUserController@findByRut');
  Route::get('/activity-course-registered-user/{id}', 'ActivityCourseRegisteredUserController@findByIdRegisteredUserCourse');

  //alumnos

  Route::put('/course-registered-user/classroom/{id}', 'CourseRegisteredUserController@updateClassroom');


  //rels
  Route::get('/type-tickets/{type_ticket}/tickets', 'TypeTicketController@tickets')->name('api.typeTickets.tickets');
  Route::get('/activities/{activity}/activity-course-registered-users', 'ActivityController@activityCourseRegisteredUsers')->name('api.activities.activityCourseRegisteredUsers');
  Route::get('/categories/{category}/courses', 'CategoryController@courses')->name('api.categories.courses');
  Route::get('/status-tickets/{status_ticket}/tickets', 'StatusTicketController@tickets')->name('api.statusTickets.tickets');
  Route::get('/priority-tickets/{priority_ticket}/tickets', 'PriorityTicketController@tickets')->name('api.priorityTickets.tickets');
  Route::get('/motive-tickets/{motive_ticket}/tickets', 'MotiveTicketController@tickets')->name('api.motiveTickets.tickets');
  Route::get('/activities/{activity}/activity-course-users', 'ActivityController@activityCourseUsers')->name('api.activities.activityCourseUsers');
  Route::get('/categories/{category}/courses', 'CategoryController@courses')->name('api.categories.courses');
  Route::get('/final-statuses/{final_status}/course-registered-users', 'FinalStatusController@courseRegisteredUsers')->name('api.finalStatuses.courseRegisteredUsers');
  Route::get('/classrooms/{classroom}/tickets', 'ClassroomController@tickets')->name('api.classrooms.courseRegisteredUsers');
  Route::get('/roles/{role}/users', 'RoleController@users')->name('api.roles.users');
  Route::get('/source-tickets/{source_ticket}/tickets', 'SourceTicketController@tickets')->name('api.sourceTickets.tickets');
  Route::get('/profiles/{profile}/course-registered-users', 'ProfileController@courseRegisteredUsers')->name('api.profiles.courseRegisteredUsers');

  Route::get('/courses/{course}/activities', 'CourseController@activities')->name('api.courses.activities');
  Route::get('/courses/{course}/registered-users', 'CourseController@registeredUsers')->name('api.courses.registeredUsers');
  Route::get('/courses/{course}/registered-users/{registered_user}', 'CourseController@registeredUser')->name('api.courses.registeredUsers.show');
  Route::get('/courses/{course}/registered-users/{registered_user}/activities', 'CourseController@userActivities')->name('api.courses.registeredUsers.activities');



  Route::get('/course-users/{course_user}/activities', 'CourseRegisteredUserController@activities')->name('api.courseRegisteredUsers.activities');

  Route::get('/course-users/{idUser}/courses', 'CourseRegisteredUserController@findUserCourses')->name('api.courseRegisteredUsers.courses');

  Route::get('/course-registered-user/{idRegisteredUser}/courses/{idCourse}', 'CourseRegisteredUserController@findSpecificUserCourse');


  Route::get('/course-registered-user/{idCourse}/users', 'CourseRegisteredUserController@findUserCourseByCourse')->name('api.courseRegisteredUsers.users');
  Route::get('/platforms/{platform}/categories', 'PlatformController@categories')->name('api.platforms.categories');



  Route::get('/registered-users/{registered_user}/courses', 'RegisteredUserController@courses')->name('api.registeredUsers.courses');
  Route::get('/registered-users/{registered_user}/courses/{course}', 'RegisteredUserController@course')->name('api.registeredUsers.courses.show');
  Route::get('/registered-users/{registered_user}/courses/{course}/activities', 'RegisteredUserController@activities')->name('api.registeredUsers.activities');
  Route::get('/registered-users/{registered_user}/tickets', 'RegisteredUserController@tickets')->name('api.registeredUsers.tickets');

  Route::get('/status-detail-tickets/{status_detail_ticket}/ticket-details', 'StatusDetailTicketController@ticketDetails')->name('api.statusDetailTickets.ticketDetails');
  Route::get('/tickets/{ticket}/ticket-details', 'TicketController@ticketsDetails')->name('api.tickets.ticketsDetails');

  Route::post('/upload-file', 'UploadFileController@fileSubmit')->name('api.upload');
  Route::get('/download-file/excel/{id}/{description}', 'CourseRegisteredUserController@downloadExcelCourseRegistered');

  //custom methods
  Route::post('/courses/post', 'CourseController@storeVue');
  Route::post('/categories/post', 'CategoryController@storeVue');
  Route::put('/categories/put/{category}', 'CategoryController@updateVue');

  Route::post('/registered-users/view-store', 'RegisteredUserController@storeFromView')->name('api.registeredUsers.viewStore');
  Route::post('/course-registered-users/view-store', 'CourseRegisteredUserController@storeFromView')->name('api.courseRegisteredUsers.viewStore');

  Route::get('/registered-users/{idUserMoodle}/findByMoodle', 'RegisteredUserController@findByIdRegisteredUserMoodle')->name('api.registeredUsers.findByIdMoodle');

  //subir archivos de matricula alumnos
  Route::get('/upload-file/excel', 'RegisteredUserController@import');

  //test

  Route::get('/sync-moodle-student', 'SynchronizeController@syncMoodleStudents');

  //sincronización con mooodle

  Route::get('/sync/course-users/{idCourseMoodle}/users/{rut}', 'SynchronizeController@syncUser');
  Route::get('/sync/course-users/{idCourseMoodle}/users', 'SynchronizeController@syncUsersByCourse');
  Route::get('/sync/course/{idCourseMoodle}/activities', 'SynchronizeController@syncActivitiesByCourse');

  Route::get('/sync/courses/{idCourseMoodle}/classrooms/{idClassroom}/activities', 'SynchronizeController@syncActivitiesByClassroom');

  Route::get('/sync/users/{idRegisteredUser}/courses/{idCourse}/activities', 'SynchronizeController@syncActivitiesByUser');


  //form

  Route::get('/form/ticket/post', 'FormController\TicketFormController@postForm');
  Route::get('/form/ticket/put/{id}', 'FormController\TicketFormController@putForm');
});
