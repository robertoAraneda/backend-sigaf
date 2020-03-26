<?php

namespace App\Http\Controllers;

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

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store($activityCourseRegisteredUserMoodle)
  {
    $activityCourseRegisteredUser = new ActivityCourseRegisteredUser();

    $activityCourseRegisteredUser->activity_id = $activityCourseRegisteredUserMoodle['idacividad'];
    $activityCourseRegisteredUser->course_registered_user_id = $activityCourseRegisteredUserMoodle['idinscrito'];
    $activityCourseRegisteredUser->qualification_moodle = $activityCourseRegisteredUserMoodle['calificacion'];
    $activityCourseRegisteredUser->status_moodle = $activityCourseRegisteredUserMoodle['estado'];

    $activityCourseRegisteredUser->save();

    return $activityCourseRegisteredUser->fresh();
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
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
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
