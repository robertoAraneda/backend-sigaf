<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;


class CourseController extends Controller
{
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
