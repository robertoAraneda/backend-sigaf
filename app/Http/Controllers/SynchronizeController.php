<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCourseRegisteredUser;
use App\Models\Course;
use App\Models\CourseRegisteredUser;
use App\Models\Platform;
use App\Models\RegisteredUser;
use App\Models\Rut;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SynchronizeController extends Controller
{
    private $base_url;

    public function __construct()
    {
        $this->base_url = "http://ayuda2-emineduc.iie.cl/iie-inacap/public/api/";
    }

    public function getBASE_URL()
    {
        return $this->base_url;
    }

    public function synchronizeApp()
    {
        $base_url = 'http://ayuda2-emineduc.iie.cl/iie-inacap/public/';

        // $response = Http::get($base_url . "api/collection/plataforma");

        // $platforms = $response->json();

        // $array = [];

        // /**insertar plataformas */
        // foreach ($platforms as $platform) {

        //   $platformController = new PlatformController();

        //   $searchPlatform = $platformController->findByDescription($platform['nombre']);

        //   if (!isset($searchPlatform)) {
        //     $platformController->store($platform);
        //   }
        // }

        // /**insertar categorias */
        // foreach ($platforms as $platform) {

        //   $platformController = new PlatformController();

        //   $platformResponse = $platformController->findByDescription($platform['nombre']);

        //   foreach ($platform['categories'] as $category) {

        //     $categoryController = new CategoryController();

        //     $categorySearch = $categoryController->findByIdCategoryMoodle($category['idcategory']);

        //     if (!isset($categorySearch)) {

        //       $category['idplataforma'] = $platformResponse->id;

        //       $categoryController->store($category);
        //     } else {

        //       $categoryAndPlatform = $categoryController->findByIdPlatformAndCategoryMoodle($category['idcategory'], $platformResponse->id);

        //       if (($category['idplataforma'] == $platform['idplataforma']) && (!isset($categoryAndPlatform))) {

        //         $category['idplataforma'] = $platformResponse->id;

        //         $categoryController->store($category);
        //       }
        //     }
        //   }
        // }

        // /**insertar coursos */
        // foreach ($platforms as $platform) {

        //   $platformController = new PlatformController();

        //   $platformResponse = $platformController->findByDescription($platform['nombre']);

        //   foreach ($platform['categories'] as $category) {

        //     $categoryController = new CategoryController();

        //     $categorySearch = $categoryController->findByIdCategoryMoodle($category['idcategory']);

        //     foreach ($category['coursesFormat'] as $course) {

        //       $courseController = new CourseController();

        //       $categoryResponse = $categoryController->findByIdPlatformAndCategoryMoodle($course['idcategory'], $platformResponse->id);

        //       $courseResponse = $courseController->findByIdCourseMoodle($course['idcurso']);

        //       if (($course['idcategory'] == $category['idcategory']) && ($course['idplataforma'] == $category['idplataforma'])) {

        //         if (!isset($courseResponse)) {

        //           $course['idcategory'] = $categoryResponse->id;

        //           $courseController->store($course);
        //         }
        //       }

        //       $array[] = $course;
        //     }
        //   }
        // }

        // $response2 = Http::get($base_url . "api/collection/actividades");

        // $activities = $response2->json();

        // /**insertar actividades */
        // foreach ($activities as $activity) {

        //   $courseController = new CourseController();
        //   $activityController = new ActivityController();

        //   $course = $courseController->findByIdCourseMoodle($activity['curso']['idcurso']);

        //   $activitySearch = $activityController->findByIdActivityMoodle($activity['idmod']);

        //   if (!isset($activitySearch)) {
        //     $activity['idrcurso'] = $course->id;

        //     $activityController->store($activity);
        //   }
        // }

        // $response3 = Http::get($base_url . "api/collection/inscritos");

        // $courseRegisteredUsersMoodle = $response3->json();


        // /**insertar inscritos y cursos */
        // foreach ($courseRegisteredUsersMoodle as $courseRegisteredUserMoodle) {
        //   $registeredUserController = new RegisteredUserController();

        //   $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($courseRegisteredUserMoodle['iduser']);


        //   if (!isset($registeredUserSearch)) {

        //     $registeredUserSearch = $registeredUserController->store($courseRegisteredUserMoodle);
        //   }

        //   if (isset($registeredUserSearch)) {

        //     $courseController = new CourseController();

        //     $courseSearch = $courseController->findByIdCourseMoodle($courseRegisteredUserMoodle['curso']['idcurso']);

        //     if (isset($courseSearch)) {

        //       $courseRegisteredUserMoodle['curso']['idrcurso'] = $courseSearch->id;
        //       $courseRegisteredUserMoodle['iduser'] = $registeredUserSearch->id;


        //       $courseRegisteredUserController = new CourseRegisteredUserController();

        //       $courseRegistereduserSearch = $courseRegisteredUserController->findByIdCourseRegisteredUser($courseRegisteredUserMoodle);

        //       if (!isset($courseRegistereduserSearch)) {
        //         $courseRegisteredUserController->store($courseRegisteredUserMoodle);
        //       }
        //     }
        //   }
        // }


        $response5 = Http::get($base_url . "collection/inscrito-actividad/active");

        $registeredUserActivities = $response5->json()['data'];

        foreach ($registeredUserActivities as $registeredUserActivity) {
            $courseRegistereduserController = new CourseRegisteredUserController();
            $activityController = new ActivityController();
            $courseController = new CourseController();
            $registeredUserController = new RegisteredUserController();
            $activityCourseRegisteredUserController = new ActivityCourseRegisteredUserController();

            $courseSearch = $courseController->findByIdCourseMoodle($registeredUserActivity['user_registered']['curso']['idcurso']);
            $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($registeredUserActivity['user_registered']['iduser']);

            $activitySearch = $activityController->findByIdActivityMoodle($registeredUserActivity['activity']['idmod']);

            $registeredUserActivityFormat['curso']['idrcurso'] = $courseSearch->id;
            $registeredUserActivityFormat['iduser'] = $registeredUserSearch->id;

            $courseRegisteredUserSearch = $courseRegistereduserController->findByIdCourseRegisteredUser($registeredUserActivityFormat);

            if (isset($courseSearch) && isset($registeredUserSearch) && isset($courseRegisteredUserSearch) && isset($activitySearch)) {
                $activityCourseRegisteredUserSearch = $activityCourseRegisteredUserController->findByIdActivityCourseRegisteredUser($activitySearch->id, $courseRegisteredUserSearch->id);

                if (!isset($activityCourseRegisteredUserSearch)) {
                    $registeredUserActivity['idinscrito'] = $courseRegisteredUserSearch->id;
                    $registeredUserActivity['idacividad'] = $activitySearch->id;

                    $response = $activityCourseRegisteredUserController->store($registeredUserActivity);
                }
            }
        }
    }


    public function syncronizeAppPlatformsCategoriesDaily()
    {
        $response = Http::get($this->getBASE_URL() . "collection/categorias/all");



        $categoriesActive = $response->json();


        foreach ($categoriesActive as $category) {
            $platformController = new PlatformController();

            $categoryController = new CategoryController();

            $platformSearch = $platformController->findByDescription($category['plataforma']['nombre']);

            if (!isset($platformSearch)) {
                $platformController->store($category['plataforma']);
            } else {
                $platformController->update($platformSearch->id, $category['plataforma']);
            }

            $platformSearch = $platformController->findByDescription($category['plataforma']['nombre']);

            $categorySearch = $categoryController->findByIdPlatformAndCategoryMoodle($category['idcategory'], $platformSearch->id);

            $categories[] = $category;

            $category['idplataforma']  = $platformSearch->id;

            if (!isset($categorySearch)) {
                $categoryController->store($category);
            } else {
                $categoryController->update($categorySearch->id, $category);
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }


    public function synchronizeAppCoursesActive()
    {
        $response2 = Http::get($this->getBASE_URL() . "collection/cursos/all");

        $activeCourses = $response2->json();

        foreach ($activeCourses as $activeCourse) {
            $courseController = new CourseController();
            $categoryController = new CategoryController();

            $categorySearch = $categoryController->findByIdCategoryMoodle($activeCourse['idcategory']);

            $activeCourseSearch = $courseController->findByIdCourseMoodle($activeCourse['idcurso']);

            if (!isset($activeCourseSearch)) {
                $activeCourse['idcategory'] = $categorySearch->id;

                $courseController->store($activeCourse);
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function syncronizeAppActivitiesActive()
    {
        $response3 = Http::get($this->getBASE_URL() . "collection/actividades/all");

        $activeActivities = $response3->json();

        foreach ($activeActivities as $activeActivity) {
            $courseController = new CourseController();
            $activityController = new ActivityController();

            $courseSearch = $courseController->findByIdCourseMoodle($activeActivity['curso']['idcurso']);

            $activeActivitySearch = $activityController->findByIdActivityMoodle($activeActivity['idmod']);

            if (!isset($activeActivitySearch)) {
                $activeActivity['idrcurso'] = $courseSearch->id;

                $activityController->store($activeActivity);
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function syncronizeAppRegisteredUsersActive()
    {
        $response4 = Http::get($this->getBASE_URL() . "collection/inscrito/filtered");

        $activeRegisteredUsers = $response4->json();

        foreach ($activeRegisteredUsers as $activeRegisteredUser) {
            $registeredUserController = new RegisteredUserController();
            $courseController = new CourseController();
            $courseRegisteredUserController = new CourseRegisteredUserController();


            $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($activeRegisteredUser['iduser']);

            if (!isset($registeredUserSearch)) {
                $registeredUserSearch = $registeredUserController->store($activeRegisteredUser);
            } else {
                $registeredUserSearch = $registeredUserController->update($registeredUserSearch->id, $activeRegisteredUser);
            }

            $courseSearch = $courseController->findByIdCourseMoodle($activeRegisteredUser['curso']['idcurso']);

            $activeRegisteredUser['curso']['idrcurso'] = $courseSearch->id;
            $activeRegisteredUser['iduser'] =  $registeredUserSearch->id;

            $courseRegisteredUserSearch = $courseRegisteredUserController->findByIdCourseRegisteredUser($activeRegisteredUser);

            if (!isset($courseRegisteredUserSearch)) {
                $courseRegisteredUserController->store($activeRegisteredUser);
            } else {
                $courseRegisteredUserController->update($courseRegisteredUserSearch->id, $activeRegisteredUser);
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function syncronizeAppRegisteredUserActivitiesActive()
    {
        $response5 = Http::get($this->getBASE_URL() . "collection/inscrito-actividad/filtered");

        $registeredUserActivities = $response5->json();

        foreach ($registeredUserActivities as $keys) {
            foreach ($keys as $registeredUserActivity) {
                $courseRegistereduserController = new CourseRegisteredUserController();
                $activityController = new ActivityController();
                $courseController = new CourseController();
                $registeredUserController = new RegisteredUserController();
                $activityCourseRegisteredUserController = new ActivityCourseRegisteredUserController();

                $courseSearch = $courseController->findByIdCourseMoodle($registeredUserActivity['user_registered']['curso']['idcurso']);
                $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($registeredUserActivity['user_registered']['iduser']);

                $activitySearch = $activityController->findByIdActivityMoodle($registeredUserActivity['activity']['idmod']);

                $registeredUserActivityFormat['curso']['idrcurso'] = $courseSearch->id;
                $registeredUserActivityFormat['iduser'] = $registeredUserSearch->id;

                $courseRegisteredUserSearch = $courseRegistereduserController->findByIdCourseRegisteredUser($registeredUserActivityFormat);

                if (isset($courseSearch) && isset($registeredUserSearch) && isset($courseRegisteredUserSearch) && isset($activitySearch)) {
                    $activityCourseRegisteredUserSearch = $activityCourseRegisteredUserController->findByIdActivityCourseRegisteredUser($activitySearch->id, $courseRegisteredUserSearch->id);

                    $registeredUserActivity['idinscrito'] = $courseRegisteredUserSearch->id;
                    $registeredUserActivity['idacividad'] = $activitySearch->id;

                    if (!isset($activityCourseRegisteredUserSearch)) {
                        $activityCourseRegisteredUserController->store($registeredUserActivity);
                    } else {
                        $activityCourseRegisteredUserController->update($activityCourseRegisteredUserSearch->id, $registeredUserActivity);
                    }
                }
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function syncUser($idCourseMoodle, $rut)
    {
        $response = Http::get($this->getBASE_URL() . "course/" . $idCourseMoodle . "/users/" . $rut);

        $user = $response->json();

        if (isset($user)) {
            $rutUpper = strtoupper($user['rut']);

            list($rut, $dv) = explode("-", $rutUpper);

            $rut = new Rut($rut, $dv);

            if ($rut->validate()) {
                $localUser = RegisteredUser::where('rut', $rutUpper)->first();

                if (isset($localUser)) {
                    $localUser->id_registered_moodle = $user['iduser'];
                    $localUser->rut_registered_moodle = $user['rut'];
                    $localUser->name_registered_moodle = $user['nombre'];
                    $localUser->email_registered_moodle = $user['email'];

                    $localUser->user_update_id = auth()->id();

                    $localUser->save();

                    $localCourse = Course::where('id_course_moodle', $idCourseMoodle)->first();

                    $localCourseUser = CourseRegisteredUser::where('registered_user_id', $localUser->id)
            ->where('course_id', $localCourse->id)->first();

                    if (isset($localCourseUser)) {
                        $localCourseUser->last_access_registered_moodle = $user['ultimoacceso'];

                        $localCourseUser->save();
                    }

                    return response()->json(['data' => $localCourseUser->fresh(), 'success' => true], 201);
                } else {
                    return response()->json(['data' => $localUser, 'success' => false], 200);
                }
            } else {
                return response()->json(['data' => null, 'success' => false], 416);
            }
        } else {
            return response()->json(['data' => null, 'success' => false], 204);
        }
    }

    public function syncUsersByCourse($idCourseMoodle)
    {
        $response = Http::get($this->getBASE_URL() . "course/" . $idCourseMoodle . "/users");

        $users = $response->json();

        $arrayFindedUsers = [];
        $arrayMissedUsers = [];
        $arrayInvalidRut = [];
        $arrayCourseUserValid = [];

        try {
            if (isset($users)) {
                foreach ($users as $user) {
                    try {
                        $rutUpper = strtoupper($user['rut']);

                        list($rut, $dv) = explode("-", $rutUpper);

                        $rut = new Rut($rut, $dv);

                        if (!$rut->validate()) {
                            $arrayInvalidRut[] = $user;
                        } else {
                            $localUser = RegisteredUser::where('rut', $rutUpper)->first();

                            if (isset($localUser)) {
                                $localUser->id_registered_moodle = isset($user['iduser']) ? $user['iduser'] : null;
                                $localUser->rut_registered_moodle = isset($user['rut']) ? $rutUpper : null;
                                $localUser->name_registered_moodle = isset($user['nombre']) ? $user['nombre'] : null;
                                $localUser->email_registered_moodle = isset($user['email']) ? $user['email'] : null;

                                $localUser->save();

                                $localCourse = Course::where('id_course_moodle', $idCourseMoodle)->first();

                                $localCourseUser = CourseRegisteredUser::where('registered_user_id', $localUser->id)
                  ->where('course_id', $localCourse->id)->first();

                                if (isset($localCourseUser)) {
                                    $localCourseUser->last_access_registered_moodle = isset($user['ultimoacceso']) ? $user['ultimoacceso'] : null;
                                    $localCourseUser->is_sincronized = 1;
                                    $localCourseUser->save();

                                    $arrayCourseUserValid[] = $localCourseUser->fresh();
                                }

                                $arrayFindedUsers[] = $localUser->fresh();
                            } else {
                                $arrayMissedUsers[] = $user;
                            }
                        }
                    } catch (\Exception $ex) {
                        $arrayInvalidRut[] = $user;
                    }
                }

                return response()->json(
                    [
            'userInvalid' => $arrayInvalidRut,
            'userFinded' => $arrayFindedUsers,
            'userMissed' => $arrayMissedUsers,
            'userCourseValid' => $arrayCourseUserValid

          ],
                    201
                );
            } else {
                return response()->json(['users' => null], 204);
            }
        } catch (\Exception $ex) {
            return response()->json(
                [
          'userInvalid' => $arrayInvalidRut,
          'userFinded' => $arrayFindedUsers,
          'userMissed' => $arrayMissedUsers,
          'userCourseValid' => $arrayCourseUserValid,
          'users' => $users

        ],
                200
            );
        }
    }

    public function syncActivitiesByCourse($idCourseMoodle)
    {
        try {
            $response = Http::get($this->getBASE_URL() . "course/" . $idCourseMoodle);

            $course = $response->json();


            $responseActivities = Http::get($this->getBASE_URL() . "course/" . $course['idrcurso'] . "/activities");

            $activities = $responseActivities->json();

            foreach ($activities as $activity) {
                $localActivity = Activity::where('id_activity_moodle', $activity['idmod'])->first();
                $course = Course::where('id_course_moodle', $idCourseMoodle)->first();

                $section = Section::where('description', 'Formativa')->first();

                if (!isset($localActivity)) {
                    $storeActivity = new Activity();
                    $course = Course::where('id_course_moodle', $idCourseMoodle)->first();

                    $storeActivity->description = $activity['nombre'];
                    $storeActivity->type = $activity['tipo'];
                    $storeActivity->section_id = $section->id;
                    $storeActivity->weighing = 0;
                    $storeActivity->id_activity_moodle = $activity['idmod'];
                    $storeActivity->course_id = $course->id;

                    $storeActivity->save();
                } else {
                    $localActivity->description = $activity['nombre'];
                    $localActivity->type = $activity['tipo'];
                    $localActivity->id_activity_moodle = $activity['idmod'];
                    $localActivity->course_id = $course->id;

                    $localActivity->save();
                }
            }

            return response()->json(['success' => true, 'error' => null], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }
    }

    public function syncActivitiesByClassroom($courseMoodle, $classroom)
    {
        try {
            $course = Course::where('id_course_moodle', $courseMoodle)->first();

            if ($classroom == 'all') {
                $users = CourseRegisteredUser::where('course_id', $course->id)->with('registeredUser')->get();
            } else {
                $users = CourseRegisteredUser::where('course_id', $course->id)->where('classroom_id', $classroom)->with('registeredUser')->get();
            }

            $arrayActivities = [];



            if (count($users) != 0) {
                foreach ($users as $user) {
                    if (isset($user)) {
                        $response = Http::get($this->getBASE_URL() . "users/" . $user->registeredUser->id_registered_moodle . "/courses/" . $courseMoodle . "/activities");

                        $activities = $response->json();

                        if (count($activities) != 0) {
                            foreach ($activities as $activity) {
                                $localActivity = Activity::where('id_activity_moodle', $activity['activity']['idmod'])->first();

                                if (isset($localActivity)) {
                                    $actualActivity = ActivityCourseRegisteredUser::where('activity_id', $localActivity->id)->where('course_registered_user_id', $user->id)
                    ->with(['courseRegisteredUser', 'courseRegisteredUser.course'])
                    ->first();

                                    if (isset($actualActivity)) {
                                        $actualActivity->status_moodle = $activity['estado'];
                                        $actualActivity->qualification_moodle = $activity['calificacion'];

                                        $actualActivity->save();
                                        $arrayActivities[] = $actualActivity;
                                    } else {
                                        $storeActivityDetail = new ActivityCourseRegisteredUser();

                                        $storeActivityDetail->activity_id = $localActivity->id;
                                        $storeActivityDetail->course_registered_user_id = $user->id;

                                        $storeActivityDetail->status_moodle = $activity['estado'];
                                        $storeActivityDetail->qualification_moodle = $activity['calificacion'];

                                        $storeActivityDetail->save();

                                        $arrayActivities[] = $storeActivityDetail;
                                    }
                                }
                            }
                        }
                    }
                }
            }




            return response()->json(['success' => true, 'error' => null, 'data' => $arrayActivities], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage(), 'data' => null], 500);
        }
    }

    public function syncContributeActivities($courseMoodle, $userMoodle, $arrayActivities)
    {
        try {
            $response = Http::get($this->getBASE_URL() . "users/" . $userMoodle . "/courses/" . $courseMoodle . "/activities/" . $arrayActivities);

            $activities = $response->json();

            $course = Course::where('id_course_moodle', $courseMoodle)->first();

            $registeredUser = RegisteredUser::where('id_registered_moodle', $userMoodle)->first();

            $courseUser = CourseRegisteredUser::where('registered_user_id', $registeredUser->id)->where('course_id', $course->id)->first();

            $arrayActivities = [];


            if (count($activities['data']['relActivityuser']) != 0) {
                foreach ($activities['data']['relActivityuser'] as $activity) {
                    if ($activity != null) {
                        $localActivity = Activity::where('id_activity_moodle', $activity['activity']['idmod'])->first();
                    }

                    if (isset($localActivity)) {
                        $actualActivity = ActivityCourseRegisteredUser::where('activity_id', $localActivity->id)->where('course_registered_user_id', $courseUser->id)
              ->with(['courseRegisteredUser', 'courseRegisteredUser.course'])
              ->first();

                        if (isset($actualActivity)) {
                            $actualActivity->status_moodle = $activity['estado'];
                            $actualActivity->qualification_moodle = $activity['calificacion'];

                            $actualActivity->save();
                            $arrayActivities[] = $actualActivity;
                        } else {
                            $storeActivityDetail = new ActivityCourseRegisteredUser();

                            $storeActivityDetail->activity_id = $localActivity->id;
                            $storeActivityDetail->course_registered_user_id = $courseUser->id;

                            $storeActivityDetail->status_moodle = $activity['estado'];
                            $storeActivityDetail->qualification_moodle = $activity['calificacion'];

                            $storeActivityDetail->save();

                            $arrayActivities[] = $storeActivityDetail;
                        }
                    }
                }
            }
            return response()->json(['success' => true, 'error' => null, 'data' => $arrayActivities], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage(), 'data' => null], 500);
        }
    }

    public function syncActivitiesByUser($idUserRegistered, $idCourse)
    {
        try {
            $registeredUser = RegisteredUser::find($idUserRegistered);

            $course = Course::find($idCourse);
            $arrayActivities = [];
            if (isset($registeredUser) && isset($course)) {
                $response = Http::get($this->getBASE_URL() . "users/" . $registeredUser->id_registered_moodle . "/courses/" . $course->id_course_moodle . "/activities");

                $activities = $response->json();

                $courseUser = CourseRegisteredUser::where('registered_user_id', $registeredUser->id)->where('course_id', $course->id)->first();

                foreach ($activities as $activity) {
                    $localActivity = Activity::where('id_activity_moodle', $activity['activity']['idmod'])->first();

                    if (isset($localActivity)) {
                        $actualActivity = ActivityCourseRegisteredUser::where('activity_id', $localActivity->id)->where('course_registered_user_id', $courseUser->id)
              ->with(['courseRegisteredUser', 'courseRegisteredUser.course'])
              ->first();

                        if (isset($actualActivity)) {
                            $actualActivity->status_moodle = $activity['estado'];
                            $actualActivity->qualification_moodle = $activity['calificacion'];

                            $actualActivity->save();
                            $arrayActivities[] = $actualActivity->fresh();
                        } else {
                            $storeActivityDetail = new ActivityCourseRegisteredUser();

                            $storeActivityDetail->activity_id = $localActivity->id;
                            $storeActivityDetail->course_registered_user_id = $courseUser->id;

                            $storeActivityDetail->status_moodle = $activity['estado'];
                            $storeActivityDetail->qualification_moodle = $activity['calificacion'];

                            $storeActivityDetail->save();

                            $arrayActivities[] = $storeActivityDetail;
                        }
                    }
                }
            }
            return response()->json(['success' => true, 'error' => null, 'data' => $arrayActivities], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage(), 'data' => null], 500);
        }
    }

    public function syncronizeAppDaily()
    {
        $this->syncronizeAppRegisteredUsersActive();
        $this->syncronizeAppRegisteredUserActivitiesActive();
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }


    public function syncMoodleStudents()
    {

    // $registeredUserController = new RegisteredUserController();
    // $response4 = Http::get($this->getBASE_URL() . "collection/inscrito/all");

    // $studentsMoodle =  $response4->json();

    // $array_student = array();

    // $response =  $registeredUserController->import();

    // Storage::delete('carga_alumnos.xlsx');


    // foreach ($response as $res) {
    //   foreach ($studentsMoodle as $student) {
    //     if (
    //       strtoupper($student['rut']) == strtoupper($res['rut'])
    //       && 773 == $student['idrcurso']
    //     ) {
    //       $student['id'] = $res['id'];
    //       $array_student[] = $student;
    //     }
    //   }
    // }
    // return $array_student;
    }


    public function syncronizeAppRegisteredUsersActiveInit()
    {
        $response4 = Http::get($this->getBASE_URL() . "collection/inscrito/all");

        $activeRegisteredUsers = $response4->json();

        foreach ($activeRegisteredUsers as $activeRegisteredUser) {
            $registeredUserController = new RegisteredUserController();
            $courseController = new CourseController();
            $courseRegisteredUserController = new CourseRegisteredUserController();


            $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($activeRegisteredUser['iduser']);

            if (!isset($registeredUserSearch)) {
                $registeredUserSearch = $registeredUserController->store($activeRegisteredUser);
            }

            $courseSearch = $courseController->findByIdCourseMoodle($activeRegisteredUser['curso']['idcurso']);

            $activeRegisteredUser['curso']['idrcurso'] = $courseSearch->id;
            $activeRegisteredUser['iduser'] =  $registeredUserSearch->id;

            $courseRegisteredUserSearch = $courseRegisteredUserController->findByIdCourseRegisteredUser($activeRegisteredUser);

            if (!isset($courseRegisteredUserSearch)) {
                $courseRegisteredUserController->store($activeRegisteredUser);
            } else {
                $courseRegisteredUserController->update($courseRegisteredUserSearch->id, $activeRegisteredUser);
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function syncronizeAppRegisteredUserActivitiesActiveInit()
    {
        $response5 = Http::get($this->getBASE_URL() . "collection/inscrito-actividad/all");

        $registeredUserActivities = $response5->json();

        foreach ($registeredUserActivities as $keys) {
            foreach ($keys as $registeredUserActivity) {
                $courseRegistereduserController = new CourseRegisteredUserController();
                $activityController = new ActivityController();
                $courseController = new CourseController();
                $registeredUserController = new RegisteredUserController();
                $activityCourseRegisteredUserController = new ActivityCourseRegisteredUserController();

                $courseSearch = $courseController->findByIdCourseMoodle($registeredUserActivity['user_registered']['curso']['idcurso']);
                $registeredUserSearch = $registeredUserController->findByIdRegisteredUserMoodle($registeredUserActivity['user_registered']['iduser']);

                $activitySearch = $activityController->findByIdActivityMoodle($registeredUserActivity['activity']['idmod']);

                $registeredUserActivityFormat['curso']['idrcurso'] = $courseSearch->id;
                $registeredUserActivityFormat['iduser'] = $registeredUserSearch->id;

                $courseRegisteredUserSearch = $courseRegistereduserController->findByIdCourseRegisteredUser($registeredUserActivityFormat);

                if (isset($courseSearch) && isset($registeredUserSearch) && isset($courseRegisteredUserSearch) && isset($activitySearch)) {
                    $activityCourseRegisteredUserSearch = $activityCourseRegisteredUserController->findByIdActivityCourseRegisteredUser($activitySearch->id, $courseRegisteredUserSearch->id);

                    $registeredUserActivity['idinscrito'] = $courseRegisteredUserSearch->id;
                    $registeredUserActivity['idacividad'] = $activitySearch->id;

                    if (!isset($activityCourseRegisteredUserSearch)) {
                        $activityCourseRegisteredUserController->store($registeredUserActivity);
                    } else {
                        $activityCourseRegisteredUserController->update($activityCourseRegisteredUserSearch->id, $registeredUserActivity);
                    }
                }
            }
        }
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }


    public function synchronizeAppInit()
    {
        $this->syncronizeAppPlatformsCategoriesDaily();
        $this->synchronizeAppCoursesActive();
        $this->syncronizeAppRegisteredUsersActiveInit();
        $this->syncronizeAppActivitiesActive();
        $this->syncronizeAppRegisteredUserActivitiesActiveInit();
        return response()->json([
      'success' => true,
      'error' => null
    ], 200);
    }

    public function findUsersByPendingActivity($id, $idCourse)
    {
        $ids = json_decode($id);

        if (count($ids) > 0) {
            $url = $this->getBASE_URL() . "activities/" . $id . "/course-users";

            $response5 = Http::get($url);

            $registeredUserActivities = $response5->json();

       //s     return response()->json($registeredUserActivities);

            $users['usersWithPendingActivities'] = [];

            foreach ($registeredUserActivities as $value) {
                $findUser = RegisteredUser::where('id_registered_moodle', $value['iduser'])->first();

                $users['all'][] =   $findUser;
                $users['value'][] = $value['iduser'];

                if (isset($findUser)) {
                    $courseRegisteredUser = CourseRegisteredUser::where('registered_user_id', $findUser->id)
                        ->where('course_id', $idCourse)
                        ->with([
                        'course',
                        'classroom',
                        'registeredUser',
                        'profile',
                        'finalStatus',
                        'activityCourseUsers.activity.section'
                        ])
                        ->first();

                    if (isset($courseRegisteredUser)) {
                        $users['usersWithPendingActivities'][] =  $courseRegisteredUser;
                    }
                }
            }
            $users['count'] = count($users['usersWithPendingActivities']);

            return response()->json($users);
        } else {
            $courseRegisteredUser['usersWithPendingActivities'] = CourseRegisteredUser::where('course_id', $idCourse)
        ->with([
          'course',
          'classroom',
          'registeredUser',
          'profile',
          'finalStatus',
          'activityCourseUsers.activity.section'
        ])
        ->get();
        }
        return response()->json($courseRegisteredUser);
    }
}
