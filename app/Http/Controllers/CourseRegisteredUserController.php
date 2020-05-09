<?php

namespace App\Http\Controllers;

use App\Models\CourseRegisteredUser;
use App\Http\Resources\Json\ActivityCourseRegisteredUser as JsonActivityCourseUser;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;

class CourseRegisteredUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $courseRegisteredUsers = CourseRegisteredUser::with([
      'course',
      'classroom',
      'registeredUser',
      'profile',
      'finalStatus'
    ])->get();

    return response()->json(['data' => $courseRegisteredUsers, 'success' => true]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function store($courseRegisteredUserMoodle)
  {
    $courseRegisteredUser = new CourseRegisteredUser();

    $courseRegisteredUser->course_id =  $courseRegisteredUserMoodle['curso']['idrcurso'];
    $courseRegisteredUser->registered_user_id = $courseRegisteredUserMoodle['iduser'];
    $courseRegisteredUser->last_access_registered_moodle = $courseRegisteredUserMoodle['ultimoacceso'];

    $courseRegisteredUser->save();

    return $courseRegisteredUser;
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

  public function findByIdCourseRegisteredUser($courseRegisteredUserMoodle)
  {
    $courseRegisteredUser = CourseRegisteredUser::where('course_id', $courseRegisteredUserMoodle['curso']['idrcurso'])->where('registered_user_id', $courseRegisteredUserMoodle['iduser'])->first();

    return $courseRegisteredUser;
  }



  public function update($id, $courseRegisteredUserMoodle)
  {
    $courseRegisteredUser = CourseRegisteredUser::whereId($id)->first();

    $courseRegisteredUser->course_id =  $courseRegisteredUserMoodle['curso']['idrcurso'];
    $courseRegisteredUser->registered_user_id = $courseRegisteredUserMoodle['iduser'];
    $courseRegisteredUser->last_access_registered_moodle = $courseRegisteredUserMoodle['ultimoacceso'];

    $courseRegisteredUser->save();

    return $courseRegisteredUser;
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

  public function activityCourseUsers($id)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseRegisteredUserModel = CourseRegisteredUser::find($id);

      if (!isset($courseRegisteredUserModel))
        return $this->response->noContent();

      $courseRegisteredUserFormated = new JsonCourseRegisteredUser($courseRegisteredUserModel);

      $courseRegisteredUserFormated->activityCourseUsers = [
        'activity' => $courseRegisteredUserFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.activities.activityCourseUsers',
              ['id' => $courseRegisteredUserFormated->id],
              false
            ),
            'rel' => '/rels/activityCourseUsers',
          ],


          'collections' => [
            'numberOfElements' => $courseRegisteredUserFormated->activityCourseUsers->count(),
            'data' => $courseRegisteredUserFormated->activityCourseUsers->map(function ($activityCourseUser) {
              return new JsonActivityCourseUser($activityCourseUser);
            })
          ]
        ]
      ];

      return $this->response->success($courseRegisteredUserFormated->activityCourseUsers);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
