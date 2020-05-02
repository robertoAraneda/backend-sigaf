<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\ActivityCourseRegisteredUserCollection;
use App\Models\ActivityCourseRegisteredUser;

class ActivityCourseRegisteredUserController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $activityCourseRegisteredUsers = new ActivityCourseRegisteredUserCollection(ActivityCourseRegisteredUser::all());

      if (!isset($activityCourseRegisteredUser))
        return $this->response->noContent();

      return $this->response->success($activityCourseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $activityCourseRegisteredUser = ActivityCourseRegisteredUser::find($id);

      if (!isset($activityCourseRegisteredUser))
        return $this->response->noContent();

      return $this->response->success($activityCourseRegisteredUser->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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
    $activityCourseRegisteredUser->course_registered_user_id = $activityCourseRegisteredUserMoodle['idinscrito'];
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

  public function findByIdRegisteredUserCourse($id)
  {
    $activityCourseRegisteredUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $id)->get()->map->format();

    return response()->json(['activityCourseRegisteredUser' => $activityCourseRegisteredUser]);
  }
}
