<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\RegisteredUser as JsonRegisteredUser;
use App\Http\Resources\Json\Activity as JsonActivity;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use App\Http\Resources\Json\ActivityCourseRegisteredUser as JsonActivityCourseRegisteredUser;
use App\Http\Resources\CourseCollection;
use App\Models\CourseRegisteredUser;
use App\Models\RegisteredUser;

/**
 * @group Course management
 */
class CourseController extends Controller
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
   * Display a listing of courses resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\CourseCollection
   * @apiResourceModel App\Models\Course
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
   * @param  Object $cursoTraidoMoodle
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
   * Display the course resource.
   *
   * @param  int  $course
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Course
   * @apiResourceModel App\Models\Course
   * 
   * @urlParam course required The ID of the course resource.
   */
  public function show($course)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($course))
        return $this->response->badRequest();

      $courseModel = Course::find($course);

      if (!isset($courseModel))
        return $this->response->noContent();

      return $this->response->success($courseModel->format());
      // return $this->response->success($course->links());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $idCourseMoodle
   * @return Object $course
   */
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
   * Display a list of activities resources related to course resource.
   *
   * @param  int  $course
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "course": "course",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/activities"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam course required The ID of the course resource.
   */
  public function activities($course)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseModel = Course::find($course);

      if (!isset($courseModel))
        return $this->response->noContent();

      $courseFormated = new JsonCourse($courseModel);

      $courseFormated->activities = [
        'course' => $courseFormated,
        'relationships' => [
          'links' => [
            'href' => route('api.courses.activities', ['course' => $courseFormated->id], false),
            'rel' => '/rels/activities',
          ],
          'collection' => [
            'numberOfElemets' => $courseFormated->activities->count(),
            'data' =>  $courseFormated->activities->map(function ($activity) {
              return new JsonActivity($activity);
            })
          ]
        ]
      ];

      return $this->response->success($courseFormated->activities);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of registered users resources related to course resource.
   *
   * @param  int  $course
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "registeredUser": "registeredUser",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/registeredUsers"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam course required The ID of the course resource.
   */
  public function registeredUsers($course)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseModel = Course::find($course);

      if (!isset($courseModel))
        return $this->response->noContent();

      $courseFormated = new JsonCourse($courseModel);

      $courseFormated->registeredUsers = [
        'course' => $courseFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.courses.registeredUsers',
              ['course' => $courseModel->id],
              false
            ),
            'rel' => '/rels/registeredUsers',
          ],

          'collection' => [
            'numberOfElements' => $courseModel->registeredUsers->count(),
            'data' => $courseFormated->registeredUsers->map(function ($courseRegisteredUser) {
              return new JsonCourseRegisteredUser($courseRegisteredUser);
            })
          ]
        ]
      ];

      return $this->response->success($courseFormated->registeredUsers);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }


  /**
   * Display the specific registered user resource related to course resource.
   *
   * @param  int  $course
   * @param  int  $registered_user
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "courseRegisteredUser": "courseRegisteredUser",
   *  "course": "course",
   *  "relationships":{
   *    "collections": {
   *      "numberOfElements": "number", 
   *      "links": {
   *         "href": "url", 
   *         "rel": "/rels/activities"}}
   *   }
   * }
   * 
   * @urlParam course required The ID of the course resource.
   * @urlParam registered_user required The ID of the registered user resource.
   */
  public function registeredUser($course, $registered_user)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $registeredUserModel = RegisteredUser::find($registered_user);

      if (!isset($registeredUserModel))
        return $this->response->noContent();

      $registeredUserFormated = new JsonRegisteredUser($registeredUserModel);

      $courseModel = Course::find($course);

      $courseRegisteredUser = CourseRegisteredUser::where('registered_user_id', $registered_user)
        ->where('course_id', $course)
        ->with('registeredUser')
        ->first();

      $registeredUserFormated->courses = [
        'links' => [
          'href' => route(
            'api.courses.registeredUsers.show',
            ['registered_user' => $registeredUserFormated->id, 'course' => $courseModel->id],
            false
          ),

          'rel' => '/rels/registeredUser'
        ],
        'courseRegisteredUser' => new JsonCourseRegisteredUser($courseRegisteredUser),
        'course' => new JsonCourse($courseModel),
        'relationships' =>
        [
          'collection' => [
            'numberOfElements' => $courseRegisteredUser->activityCourseUsers()->count(),
            'links' => [
              'href' => route(
                'api.courses.registeredUsers.activities',
                ['registered_user' => $registeredUserFormated->id, 'course' => $courseModel->id],
                false
              ),
              'rel' => '/rels/activities'
            ]
          ]
        ]

      ];

      return $this->response->success($registeredUserFormated->courses);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of activities resources related to Course for the specific user resource.
   *
   * @param  int  $course
   * @param  int  $registered_user
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "courseRegisteredUser": "courseRegisteredUser",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/activities"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam course required The ID of the course resource.
   * @urlParam registered_user required The ID of the registered user resource.
   */
  public function userActivities($course, $registered_user)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseRegisteredUser = CourseRegisteredUser::where('registered_user_id', $registered_user)
        ->where('course_id', $course)
        ->with('registeredUser')
        ->first();

      if (!isset($courseRegisteredUser))
        return $this->response->noContent();

      $courseRegisteredUser->activityCourseUsers = [

        'courseRegisteredUser' => new JsonCourseRegisteredUser($courseRegisteredUser),
        'relationships' =>
        [
          'links' => [
            'href' => route(
              'api.registeredUsers.activities',
              ['registered_user' => $courseRegisteredUser->registered_user_id, 'course' => $courseRegisteredUser->course_id],
              false
            ),

            'rel' => '/rels/activities'
          ],
          'collection' => [
            'numberOfElements' => $courseRegisteredUser->activityCourseUsers()->count(),
            'data' => $courseRegisteredUser->activityCourseUsers->map(function ($activity) {
              return new JsonActivityCourseRegisteredUser($activity);
            })
          ]
        ]
      ];

      return $this->response->success($courseRegisteredUser->activityCourseUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
