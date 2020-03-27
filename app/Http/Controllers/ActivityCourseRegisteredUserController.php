<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCourseRegisteredUser;
use Illuminate\Http\Request;

class ActivityCourseRegisteredUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }


  public function store($activityCourseRegisteredUserMoodle)
  {
    $activityCourseRegisteredUser = new ActivityCourseRegisteredUser();

    $activityCourseRegisteredUser->activity_id = $activityCourseRegisteredUserMoodle['idacividad'];
    $activityCourseRegisteredUser->course_registered_user_id = $activityCourseRegisteredUserMoodle['idinscrito'];
    $activityCourseRegisteredUser->qualification_moodle = $activityCourseRegisteredUserMoodle['calificacion'];
    $activityCourseRegisteredUser->status_moodle = $activityCourseRegisteredUserMoodle['estado'];

    $activityCourseRegisteredUser->save();

    return $activityCourseRegisteredUser;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  public function findByIdActivityCourseRegisteredUser($idActivity, $idcourseRegisteredUser)
  {
    $activityCourseRegisteredUserMoodle = ActivityCourseRegisteredUser::where('activity_id', $idActivity)
      ->where('course_registered_user_id', $idcourseRegisteredUser)->first();;

    return $activityCourseRegisteredUserMoodle;
  }

  public function update($id, $activityCourseRegisteredUserMoodle)
  {
    $activityCourseRegisteredUser = ActivityCourseRegisteredUser::whereId($id)->first();

    $activityCourseRegisteredUser->activity_id = $activityCourseRegisteredUserMoodle['idacividad'];
    $activityCourseRegisteredUser->course_registActivityered_user_id = $activityCourseRegisteredUserMoodle['idinscrito'];
    $activityCourseRegisteredUser->qualification_moodle = $activityCourseRegisteredUserMoodle['calificacion'];
    $activityCourseRegisteredUser->status_moodle = $activityCourseRegisteredUserMoodle['estado'];

    $activityCourseRegisteredUser->save();

    return $activityCourseRegisteredUser;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
