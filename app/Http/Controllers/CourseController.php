<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\Activity as JsonActivity;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\RegisteredUserCollection;
use App\Models\CourseRegisteredUser;

class CourseController extends Controller
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

      $collection = new CourseCollection(Course::orderBy('id')->get());

      if (!isset($collection))
        return $this->response->noContent();

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
  public function store($cursoTraidoMoodle)
  {
    $nuevoCurso = new Course();

    $nuevoCurso->description = $cursoTraidoMoodle['nombre'];
    $nuevoCurso->id_course_moodle  = $cursoTraidoMoodle['idcurso'];
    $nuevoCurso->category_id = $cursoTraidoMoodle['idcategory'];
    $nuevoCurso->status = $cursoTraidoMoodle['activo'];

    $nuevoCurso->save();
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

      $course = Course::find($id);

      if (!isset($course))
        return $this->response->noContent();

      return $this->response->success($course->format());
      // return $this->response->success($course->links());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }


  public function findByIdCourseMoodle($idCourseMoodle)
  {
    $course = Course::where('id_course_moodle', $idCourseMoodle)->first();

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

  public function activities($id)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = Course::find($id);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonCourse($checkModel);

      $model->activities = [
        'course' => $model,
        'relationships' => [
          'links' => [
            'href' => route('api.courses.activities', ['id' => $model->id], false),
            'rel' => '/rels/activities',
          ],
          'quantity' => $model->activities->count(),
          'collection' => $model->activities->map(function ($activity) {
            return new JsonActivity($activity);
          })
        ]
      ];

      return $this->response->success($model->activities);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }

  public function registeredUsers($id)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = Course::find($id);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonCourse($checkModel);

      $model->registeredUsers = [
        'courseRegisteredUser' => $model,
        'relationships' => [
          'links' => [
            'href' => route('api.courses.registeredUsers', ['id' => $model->id], false),
            'rel' => '/rels/registeredUsers',
          ],
          'quantity' => $model->registeredUsers->count(),
          'collection' => $model->registeredUsers->map(function ($courseRegisteredUser) {
            return new JsonCourseRegisteredUser($courseRegisteredUser);
          })
        ]
      ];

      return $this->response->success($model->registeredUsers);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
