<?php

namespace App\Http\Controllers;

use App\Exports\CourseRegisteredUserExport;
use App\Helpers\MakeResponse;
use App\Models\CourseRegisteredUser;
use App\Http\Resources\Json\ActivityCourseRegisteredUser as JsonActivityCourseUser;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CourseRegisteredUserController extends Controller
{
  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  protected function validateData($request)
  {
    return Validator::make($request, [
      'course_id' => 'required',
      'registered_user_id' => 'required'
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

      $courseRegisteredUsers = CourseRegisteredUser::with([
        'course',
        'classroom',
        'registeredUser',
        'profile',
        'finalStatus',
        'activityCourseUsers.activity.section'
      ])->get();

      return $this->response->success($courseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $courseUserModel = CourseRegisteredUser::find($id);

      if (!isset($courseUserModel))
        return $this->response->noContent();

      $courseUserModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function updateClassroom($id, Request $request)
  {
    $courseRegisteredUser = CourseRegisteredUser::whereId($id)->first();

    $courseRegisteredUser->classroom_id = $request->classroom_id;

    if (isset($request->profile_id)) {
      $courseRegisteredUser->profile_id = $request->profile_id;
    }

    $courseRegisteredUser->save();

    return $this->response->success(new JsonCourseRegisteredUser($courseRegisteredUser));
  }

  public function storeFromView()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $model = new CourseRegisteredUser();

      $model->course_id = request()->course_id;
      $model->registered_user_id = request()->registered_user_id;
      $model->classroom_id = request()->classroom_id;
      $model->profile_id = request()->profile_id;


      $model->save();

      return $this->response->created(new JsonCourseRegisteredUser($model->fresh()));
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function findUserCourses($idUser)
  {
    $courseRegisteredUser = CourseRegisteredUser::where('registered_user_id', $idUser)->get();

    return $this->response->success($courseRegisteredUser->map(function ($user) {
      return new JsonCourseRegisteredUser($user);
    }));
  }

  public function downloadExcelCourseRegistered($id, $description)
  {
    $data = ['id' => $id, 'description' => $description];

    return (new CourseRegisteredUserExport($data))->download('Archivo_CPEIP.csv', \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);
  }

  public function findSpecificUserCourse($idRegisteredUser, $idCourse)
  {
    $courseRegisteredUser = CourseRegisteredUser::where('registered_user_id', $idRegisteredUser)->where('course_id', $idCourse)->first();

    return $this->response->success(new JsonCourseRegisteredUser($courseRegisteredUser));
  }

  public function findUserCourseByCourse($idCourse)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseRegisteredUsers = CourseRegisteredUser::where('course_id', $idCourse)->with([
        'course',
        'classroom',
        'registeredUser',
        'profile',
        'finalStatus',
        'activityCourseUsers.activity.section'
      ])->get();

      return $this->response->success($courseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
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
