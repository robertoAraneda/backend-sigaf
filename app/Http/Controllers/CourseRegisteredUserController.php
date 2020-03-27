<?php

namespace App\Http\Controllers;

use App\Models\CourseRegisteredUser;
use Illuminate\Http\Request;

class CourseRegisteredUserController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function store($courseRegisteredUserMoodle)
  {
    $courseRegisteredUser = new CourseRegisteredUser();

    $courseRegisteredUser->course_id =  $courseRegisteredUserMoodle['curso']['idrcurso'];
    $courseRegisteredUser->registered_user_id = $courseRegisteredUserMoodle['iduser'];
    $courseRegisteredUser->last_access_registered_moodle = $courseRegisteredUserMoodle['ultimoacceso'];

    $courseRegisteredUser->save();

    return $courseRegisteredUser->fresh();
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

    return $courseRegisteredUser->fresh();
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
