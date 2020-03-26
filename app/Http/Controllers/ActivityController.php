<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
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
  public function store($activityMoodle)
  {
    $activity = new Activity();
    $activity->description = $activityMoodle['nombre'];
    $activity->type = $activityMoodle['tipo'];
    $activity->id_activity_moodle = $activityMoodle['idmod'];
    $activity->course_id = $activityMoodle['idrcurso'];

    $activity->save();
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

  public function findByIdActivityMoodle($idActivityMoodle)
  {
    $course = Activity::where('id_activity_moodle', $idActivityMoodle)->first();

    return $course;
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
