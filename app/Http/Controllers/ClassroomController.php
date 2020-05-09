<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\ClassroomCollection;
use App\Http\Resources\Json\Classroom as JsonClassroom;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use App\Models\Classroom;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
  /**
   * Property for make a response.
   *
   * @var  App\Helpers\MakeResponse  $response
   */
  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  /**
   * Validate the description field.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  protected function validateData($request)
  {
    return Validator::make($request, [
      'description' => 'required|max:25'
    ]);
  }

  /**
   * Display a listing of the classrooms resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\ClassroomCollection
   * @apiResourceModel App\Models\Classroom
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $classrooms = new ClassroomCollection(Classroom::all());

      return $this->response->success($classrooms);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Classroom
   * @apiResourceModel App\Models\Classroom
   */
  public function store()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $classroom = new Classroom();

      $classroom = $classroom->create(request()->all());

      return $this->response->created($classroom->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $classroom
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Classroom
   * @apiResourceModel App\Models\Classroom
   * 
   * @urlParam classroom required The ID of the classroom resource.
   */
  public function show($classroom)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($classroom))
        return $this->response->badRequest();

      $classroomModel = Classroom::find($classroom);

      if (!isset($classroomModel))
        return $this->response->noContent();

      return $this->response->success($classroomModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $classroom
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Classroom
   * @apiResourceModel App\Models\Classroom
   * 
   * @urlParam classroom required The ID of the classroom resource.
   */
  public function update($classroom)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($classroom))
        return $this->response->badRequest();

      $classroomModel = Classroom::find($classroom);

      if (!isset($classroomModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $classroomModel->update(request()->all());

      return $this->response->success($classroomModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $classroom
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam classroom required The ID of the classroom resource.
   */
  public function destroy($classroom)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($classroom))
        return $this->response->badRequest();

      $classroomModel = Classroom::find($classroom);

      if (!isset($classroomModel))
        return $this->response->noContent();

      $classroomModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of course registered users resources related to classroom resource.
   *
   * @param  int  $final_status
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "classroom": "classroom",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam classroom required The ID of the classroom resource.
   */
  public function courseRegisteredUsers($classroom)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($classroom))
        return $this->response->badRequest();

      $classroomModel = Classroom::find($classroom);

      if (!isset($classroomModel))
        return $this->response->noContent();

      $classroomFormated = new JsonClassroom($classroomModel);

      $classroomFormated->courseRegisteredUsers = [
        'finalStatus' => $classroomFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.classrooms.courseRegisteredUsers',
              ['classroom' => $classroomFormated->id],
              false
            ),
            'rel' => '/rels/courseRegisteredUsers'
          ],
          'collection' => [
            'numberOfElements' => $classroomFormated->courseRegisteredUsers->count(),
            'data' => $classroomFormated->courseRegisteredUsers->map(function ($courseRegisteredUser) {
              return new JsonCourseRegisteredUser($courseRegisteredUser);
            })
          ]
        ]
      ];

      return $this->response->success($classroomFormated->courseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
