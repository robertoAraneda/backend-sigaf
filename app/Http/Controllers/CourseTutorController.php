<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CourseTutorCollection;
use App\Models\CourseTutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseTutorController extends Controller

{
  /**
   * *Property for make a response
   * @var App\Helpers\MakeResponse $response
   */
  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  /**
   * Validate the description field.
   * @param \Illuminate\Http\Request $request
   */
  protected function validateData($request)
  {
    return Validator::make($request, [
      'course_id' => 'required',
      'tutor_id' => 'required'
    ]);
  }

  /**
   * Display a listing of courseTutors resource.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated
   * @apiResourceCollection App\Http\Resources\CourseTutorCollection
   * @apiResourceModel App\Models\CourseTutor
   */
  public function index()
  {
    try {
      if (!request()->isJson())
        return $this->responde->unauthorized();

      //$courseTutors = new CourseTutorCollection(CourseTutor::all());
      $collection = new CourseTutorCollection(CourseTutor::orderBy('id')->get());

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
  public function store(Request $request)
  {
    try {
      if (!request()->isJson())
        return $this->response->unathorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $courseTutor = new CourseTutor();

      $courseTutor->course_id = $request->input('course_id');
      $courseTutor->tutor_id = $request->input('tutor_id');

      $courseTutor->save();

      return $this->response->created($courseTutor->format());
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($course_tutor)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($course_tutor))
        return $this->response->badRequest();

      $courseTutor = CourseTutor::find($course_tutor);

      if (!isset($courseTutor))
        return $this->response->noContent();

      return $this->response->success($courseTutor->format());
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
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
  public function destroy($course_tutor)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($course_tutor))
        return $this->response->badRequest();

      $courseTutor = CourseTutor::find($course_tutor);

      if (!isset($courseTutor))
        return $this->response->noContent();

      $courseTutor->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }

  public function findByCourse($course)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($course))
        return $this->response->badRequest();

      $courseTutor = CourseTutor::where('course_id', $course)->get();

      if (!isset($courseTutor))
        return $this->response->noContent();

      return $this->response->success($courseTutor->map->format());
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }

  public function findByTutor($tutor)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($tutor))
        return $this->response->badRequest();

      $courseTutor = CourseTutor::where('tutor_id', $tutor)->get();

      if (!isset($courseTutor))
        return $this->response->noContent();

      return $this->response->success($courseTutor->map->format());
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
