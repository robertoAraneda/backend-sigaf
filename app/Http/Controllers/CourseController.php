<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\Json\Course as JsonCourse;


class CourseController extends Controller
{


  protected $response;

  public function __construct(MakeResponse $makeResponse)
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
    $courses = Course::all();

    return response()->json(['data' => $courses, 'success' => true]);
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

      return $this->response->success(new JsonCourse($course));
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
}
