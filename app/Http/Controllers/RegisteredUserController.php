<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\RegisteredUserCollection;
use App\Imports\RegisteredUserImport;
use App\Models\RegisteredUser;
use App\Http\Resources\Json\RegisteredUser as JsonRegisteredUser;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\ActivityCourseRegisteredUser as JsonActivityCourseRegisteredUser;
use App\Models\ActivityCourseRegisteredUser;
use App\Models\Course;
use App\Models\CourseRegisteredUser;

use Maatwebsite\Excel\Facades\Excel;

class RegisteredUserController extends Controller
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

      $collection = new RegisteredUserCollection(RegisteredUser::orderBy('id')->get());

      return $this->response->success($collection);
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
  public function store($registeredUserMoodle)
  {
    $registeredUser = new RegisteredUser();

    $registeredUser->id_registered_moodle = $registeredUserMoodle['iduser'];
    $registeredUser->rut_registered_moodle = $registeredUserMoodle['rut'];
    $registeredUser->name_registered_moodle = $registeredUserMoodle['nombre'];
    $registeredUser->email_registered_moodle = $registeredUserMoodle['email'];
    $registeredUser->status_moodle = $registeredUserMoodle['activo'];

    $registeredUser->save();

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])->first();

    return $registeredUser;
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

      $model = RegisteredUser::find($id);

      if (!isset($model))
        return $this->response->noContent();

      return $this->response->success($model->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function findByIdRegisteredUserMoodle($idRegisteredUserMoodle)
  {
    $registeredUser = RegisteredUser::where('id_registered_moodle', $idRegisteredUserMoodle)->first();

    return $registeredUser;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update($id, $registeredUserMoodle)
  {
    $registeredUser = RegisteredUser::whereId($id)->first();

    $registeredUser->id_registered_moodle = $registeredUserMoodle['iduser'];
    $registeredUser->rut_registered_moodle = $registeredUserMoodle['rut'];
    $registeredUser->name_registered_moodle = $registeredUserMoodle['nombre'];
    $registeredUser->email_registered_moodle = $registeredUserMoodle['email'];
    $registeredUser->status_moodle = $registeredUserMoodle['activo'];

    $registeredUser->save();

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])->first();

    return $registeredUser;
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
  public function findByRut($rut)
  {
    $registeredUser = RegisteredUser::where('rut_registered_moodle', $rut)->get()->first();

    return response()->json(['registeredUser' => $registeredUser]);
  }

  public function import()
  {
    //$excel =  Excel::import(new RegisteredUserImport, 'D:\Proyectos\inacap-iie\importFile\prueba.xlsx');
    $collection = (new RegisteredUserImport)->toCollection('D:\Proyectos\inacap-iie\importFile\prueba.xlsx');

    $array = [];
    foreach ($collection as $value) {
      foreach ($value as $key) {
        $array[] = array(
          'rut' => $key[0],
          'nombre' => $key[1],
          'last_name' => $key[2],
          'mother_last_name' => $key[3]
        );
      }
    }

    return $array;


    // return redirect('/')->with('success', 'All good!');
  }

  public function course($idUser, $idCourse)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = RegisteredUser::find($idUser);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonRegisteredUser($checkModel);

      $course = Course::find($idCourse);

      $model->courses = [

        'relationships' =>
        [
          'links' => [
            'href' => route('api.registeredUsers.courses.show', ['registered_user' => $model->id, 'course' => $idCourse], false),
            'rel' => '/rels/courses'
          ],

          'collection' => [
            'course' => new JsonCourse($course),
            'links' => [
              'href' => route('api.registeredUsers.activities', ['registered_user' => $model->id, 'course' => $course->id], false),
              'rel' => '/rels/activities'
            ]
          ]
        ]

      ];

      return $this->response->success($model->courses);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function courses($idUser)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = RegisteredUser::find($idUser);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonRegisteredUser($checkModel);

      $courseRegisteredUsers = $model->courseRegisteredUsers->load('course');

      $model->courses = [];
      foreach ($courseRegisteredUsers as $courseRegisteredUser) {
        $model->courses[] = [

          'relationships' =>
          [
            'links' => [
              'href' => route('api.registeredUsers.courses.show', ['registered_user' => $model->id, 'course' => $courseRegisteredUser->course->id], false),

              'rel' => '/rels/courses'
            ],

            'quantity' => $courseRegisteredUsers->count(),

            'collection' => [
              'course' => $courseRegisteredUser,
              'links' => [
                'href' => route('api.registeredUsers.activities', ['registered_user' => $model->id, 'course' => $courseRegisteredUser->course->id], false),
                'rel' => '/rels/activities'
              ]
            ]
          ]

        ];
      }

      $model->courses['registeredUser'] = $model;

      return $this->response->success($model->courses);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function activities($idUser, $idCourse)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = CourseRegisteredUser::where('registered_user_id', $idUser)->where('course_id', $idCourse)->with('registeredUser')->first();



      if (!isset($checkModel))
        return $this->response->noContent();

      $collections = ActivityCourseRegisteredUser::where('course_registered_user_id', $checkModel->id)->get();



      $collections->activities = [

        'registeredUser' => $checkModel,
        'relationships' =>
        [
          'links' => [
            'href' => route('api.registeredUsers.activities', ['registered_user' => $checkModel->registered_user_id, 'course' => $checkModel->course_id], false),

            'rel' => '/rels/activities'
          ],

          'quantity' => $collections->count(),

          'collection' => $collections->map(function ($activity) {
            return new JsonActivityCourseRegisteredUser($activity);
          })
        ]

      ];
      return $this->response->success($collections->activities);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
