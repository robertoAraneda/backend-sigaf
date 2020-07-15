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
use App\Models\Rut;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  protected function validateData($request)
  {
    return Validator::make($request, [
      'rut' => 'required',
      'name' => 'required',
      'last_name' => 'required',
      'email' => 'required',
      'mobile' => 'required',
      'address' => 'required',
      'region' => 'required',
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

      $collection = new RegisteredUserCollection(RegisteredUser::orderBy('id')
        ->get());

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

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])
      ->first();

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
    $registeredUser = RegisteredUser::where('id_registered_moodle', $idRegisteredUserMoodle)
      ->first();

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

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])
      ->first();

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

    $rut_ =  Rut::parse($rut);

    if ($rut_->validate()) {

      $registeredUser = RegisteredUser::where('rut', $rut)->first();

      if (isset($registeredUser)) {

        return $this->response->success($registeredUser);
      } else {
        return $this->response->noContent($registeredUser);
      }
    } else {

      return $this->response->customMessageResponse("RUT no válido", 406);
    }
  }

  public function storeFromView()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());


      if (isset(request()->id)) {
        $searchUser = RegisteredUser::find(request()->id);

        if (isset($searchUser)) {

          $searchUser->rut = request()->rut;
          $searchUser->name = request()->name;
          $searchUser->last_name = request()->last_name;
          $searchUser->email = request()->email;
          $searchUser->mobile = request()->mobile;
          $searchUser->address = request()->address;
          $searchUser->region = request()->region;


          if (isset(request()->mother_last_name)) {
            $searchUser->mother_last_name = request()->mother_last_name;
          }
          if (isset(request()->phone)) {
            $searchUser->phone = request()->phone;
          }
          if (isset(request()->city)) {
            $searchUser->city = request()->city;
          }
          if (isset(request()->rbd_school)) {
            $searchUser->rbd_school = request()->rbd_school;
          }
          if (isset(request()->name_school)) {
            $searchUser->name_school = request()->name_school;
          }
          if (isset(request()->city_school)) {
            $searchUser->city_school = request()->city_school;
          }
          if (isset(request()->region_school)) {
            $searchUser->region_school = request()->region_school;
          }
          if (isset(request()->phone_school)) {
            $searchUser->phone_school = request()->phone_school;
          }

          $searchUser->user_update_id = auth()->id();

          $searchUser->save();


          return $this->response->success($searchUser->fresh()->format());
        }
      } else {
        $newUser = new RegisteredUser();

        $newUser->rut = request()->rut;
        $newUser->name = request()->name;
        $newUser->last_name = request()->last_name;
        $newUser->email = request()->email;
        $newUser->mobile = request()->mobile;
        $newUser->address = request()->address;
        $newUser->region = request()->region;


        if (isset(request()->mother_last_name)) {
          $newUser->mother_last_name = request()->mother_last_name;
        }
        if (isset(request()->phone)) {
          $newUser->phone = request()->phone;
        }
        if (isset(request()->city)) {
          $newUser->city = request()->city;
        }
        if (isset(request()->rbd_school)) {
          $newUser->rbd_school = request()->rbd_school;
        }
        if (isset(request()->name_school)) {
          $newUser->name_school = request()->name_school;
        }
        if (isset(request()->city_school)) {
          $newUser->city_school = request()->city_school;
        }
        if (isset(request()->region_school)) {
          $newUser->region_school = request()->region_school;
        }
        if (isset(request()->phone_school)) {
          $newUser->phone_school = request()->phone_school;
        }

        $newUser->user_create_id = auth()->id();


        $newUser->save();

        return $this->response->created($newUser->fresh()->format());
      }
      // return $this->response->created($registeredUser->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function import()
  {
    //$excel =  Excel::import(new RegisteredUserImport, 'D:\Proyectos\inacap-iie\importFile\prueba.xlsx');
    $collection = (new RegisteredUserImport)
      ->toCollection(storage_path('app/upload_student.xlsx'));

    $array = [];
    foreach ($collection as $value) {
      foreach ($value as $key) {


        $array[] = array(
          'rut' => $this->formatRut(str_split($key[0])) . "-" . $key[1],
          'name'    => $key[10],
          'last_name'     => $key[11],
          'mother_last_name'    => $key[12],
          'email'    => $key[8],
          'phone'      => $key[16],
          'mobile'      => $key[17],
          'address'      => $key[14],
          'region'      => $key[15],
          'rbd_school'    => $key[18],
          'name_school'      => $key[19],
          'city_school'      => $key[23],
          'region_school'      => $key[21],
          'phone_school'    => $key[24]
        );
      }
    }

    $registeredUserCollection = array_slice($array, 1, count($array) - 1);

    $arrayRegisteredUserStore = [];

    foreach ($registeredUserCollection as $registeredUser) {
      $user = new RegisteredUser();

      $user->rut = $registeredUser['rut'];
      $user->name = $registeredUser['name'];
      $user->last_name = $registeredUser['last_name'];
      $user->mother_last_name = $registeredUser['mother_last_name'];
      $user->email = $registeredUser['email'];
      $user->phone = $registeredUser['phone'];
      $user->mobile = $registeredUser['mobile'];
      $user->address = $registeredUser['address'];
      $user->region = $registeredUser['region'];
      $user->rbd_school = $registeredUser['rbd_school'];
      $user->name_school = $registeredUser['name_school'];
      $user->city_school = $registeredUser['city_school'];
      $user->region_school = $registeredUser['region_school'];
      $user->phone_school = $registeredUser['phone_school'];

      $user->user_create_id = auth()->id();

      if (!$this->isRegisteredUserStore($user)) {
        $user->save();
      }

      $findUser = RegisteredUser::where('rut', $user->rut)->first();

      $arrayRegisteredUserStore[] = $findUser;
    }

    return $arrayRegisteredUserStore;
  }

  private function isRegisteredUserStore($registeredUser)
  {
    $user = RegisteredUser::where('rut', $registeredUser['rut'])->first();

    if (isset($user)) {
      return true;
    } else {
      return false;
    }
  }
  private function formatRut($array)
  {

    if (count($array) == 6) {
      return implode(array_slice($array, count($array) - 6, 3))
        . "." . implode(array_slice($array, count($array) - 3, 3));
    }

    if (count($array) == 7) {
      return implode(array_slice($array, count($array) - 7, 1))
        . "." . implode(array_slice($array, count($array) - 6, 3))
        . "." . implode(array_slice($array, count($array) - 3, 3));
    }


    if (count($array) == 8) {
      return implode(array_slice($array, count($array) - 8, 2))
        . "." . implode(array_slice($array, count($array) - 6, 3))
        . "." . implode(array_slice($array, count($array) - 3, 3));
    }

    if (count($array) == 9) {
      return implode(array_slice($array, count($array) - 9, 3))
        . "." . implode(array_slice($array, count($array) - 6, 3))
        . "." . implode(array_slice($array, count($array) - 3, 3));
    }
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
            'href' => route(
              'api.registeredUsers.courses.show',
              [
                'registered_user' => $model->id,
                'course' => $idCourse
              ],
              false
            ),
            'rel' => '/rels/courses'
          ],

          'collection' => [
            'course' => new JsonCourse($course),
            'links' => [
              'href' => route(
                'api.registeredUsers.activities',
                [
                  'registered_user' => $model->id,
                  'course' => $course->id
                ],
                false
              ),
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

      $registeredUserModel = RegisteredUser::find($idUser);

      if (!isset($registeredUserModel))
        return $this->response->noContent();

      $registeredUserFormated = new JsonRegisteredUser($registeredUserModel);

      $courseRegisteredUsers = $registeredUserFormated->courseRegisteredUsers->load('course');

      $registeredUserFormated->courses = [];
      foreach ($courseRegisteredUsers as $courseRegisteredUser) {
        $registeredUserFormated->courses[] = [
          'relationships' =>
          [
            'course' => $courseRegisteredUser,
            'links' => [
              'href' => route(
                'api.registeredUsers.courses.show',
                [
                  'registered_user' => $registeredUserFormated->id,
                  'course' => $courseRegisteredUser->course->id
                ],
                false
              ),

              'rel' => '/rels/courses'
            ],
            'collection' => [
              'links' => [
                'href' => route(
                  'api.registeredUsers.activities',
                  [
                    'registered_user' => $registeredUserFormated->id,
                    'course' => $courseRegisteredUser->course->id
                  ],
                  false
                ),
                'rel' => '/rels/activities'
              ]
            ]
          ]

        ];
      }

      $registeredUserFormated->courses['registeredUser'] = $registeredUserFormated;
      $registeredUserFormated->courses['numberOfElements'] = $courseRegisteredUsers->count();

      return $this->response->success($registeredUserFormated->courses);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function activities($idUser, $idCourse)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $courseRegisteredUserModel = CourseRegisteredUser::where('registered_user_id', $idUser)
        ->where('course_id', $idCourse)
        ->with('registeredUser')
        ->first();

      if (!isset($courseRegisteredUserModel))
        return $this->response->noContent();

      $activitiesByUser = ActivityCourseRegisteredUser::where('course_registered_user_id', $courseRegisteredUserModel->id)
        ->get();

      $activitiesByUser->activities = [
        'registeredUser' => $courseRegisteredUserModel,
        'relationships' =>
        [
          'links' => [
            'href' => route(
              'api.registeredUsers.activities',
              [
                'registered_user' => $courseRegisteredUserModel->registered_user_id,
                'course' => $courseRegisteredUserModel->course_id
              ],
              false
            ),
            'rel' => '/rels/activities'
          ],
          'collections' => [
            'numberOfElements' => $activitiesByUser->count(),
            'data' => $activitiesByUser->map(function ($activity) {
              return new JsonActivityCourseRegisteredUser($activity);
            })
          ]
        ]

      ];
      return $this->response->success($activitiesByUser->activities);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function tickets($idUser)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $user = CourseRegisteredUser::where('registered_user_id', $idUser)
        ->with('registeredUser')
        ->first();

      if (!isset($user))
        return $this->response->noContent();

      $tickets = Ticket::where('course_registered_user_id', $user->id)
        ->get();

      return $tickets;

      $collections = ActivityCourseRegisteredUser::where('course_registered_user_id', $user->id)
        ->get();



      $collections->activities = [

        'registeredUser' => $user,
        'relationships' =>
        [
          'links' => [
            'href' => route(
              'api.registeredUsers.activities',

              [
                'registered_user' => $user->registered_user_id,
                'course' => $user->course_id
              ],
              false
            ),

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
