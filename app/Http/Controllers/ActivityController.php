<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\ActivityCollection;
use App\Models\Activity;
use App\Http\Resources\Json\Activity as JsonActivity;
use App\Http\Resources\Json\ActivityCourseRegisteredUser as JsonActivityCourseRegisteredUser;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  protected function validateData($request)
  {
    return Validator::make($request, [
      'weighing' => 'required|integer'
    ]);
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

      $activities = new ActivityCollection(Activity::all());

      if (!isset($activities))
        return $this->response->noContent();

      return $this->response->success($activities);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $activity = Activity::find($id);

      if (!isset($activity))
        return $this->response->noContent();

      return $this->response->success(new JsonActivity($activity));
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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
  public function update($id)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $activity = Activity::whereId($id)->first();

      if (!isset($activity))
        return $this->response->noContent();

      $valitate = $this->validateData(request()->all());

      if ($valitate->fails())
        return $this->response->exception($valitate->errors());

      $activity->update(request()->all());

      return $this->response->success($activity->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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

  public function activityCourseRegisteredUsers($idActivity)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $activity = new JsonActivity(Activity::find($idActivity));

      $activity['activityCourseRegisteredUsers'] = [
        'activity' => $activity,
        'url' => route('api.activities.activityCourseRegisteredUsers', ['activity' => $activity->id]),
        'href' => route('api.activities.activityCourseRegisteredUsers', ['activity' => $activity->id], false),
        'rel' => class_basename($activity->activityCourseRegisteredUsers()->getRelated()),
        'count' => $activity->activityCourseRegisteredUsers->count(),
        'activityCourseRegisteredUsers' => $activity->activityCourseRegisteredUsers->map(function ($activityCourseRegisteredUser) {
          return new JsonActivityCourseRegisteredUser($activityCourseRegisteredUser);
        })
      ];

      return $this->response->success($activity->activityCourseRegisteredUsers);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
