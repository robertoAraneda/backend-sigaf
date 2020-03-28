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
