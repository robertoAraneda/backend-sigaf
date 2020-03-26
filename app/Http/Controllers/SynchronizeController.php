<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    $response = Http::get($this->getBASE_URL() . "collection/categorias/active");

    $categoriesActive = $response->json();


    foreach ($categoriesActive as $category) {

      $platformController = new PlatformController();

      $categoryController = new CategoryController();

      $platformSearch = $platformController->findByDescription($category['plataforma']['nombre']);

      if (!isset($platformSearch)) {

        $platformController->store($category['plataforma']);
      }

      $platformSearch = $platformController->findByDescription($category['plataforma']['nombre']);

      $categorySearch = $categoryController->findByIdPlatformAndCategoryMoodle($category['idcategory'], $platformSearch->id);

      $categories[] = $category;

      if (!isset($categorySearch)) {

        $category['idplataforma']  = $platformSearch->id;

        $categoryController->store($category);
      }
    }
    return response()->json([
      'success' => true,
      'error' => null
    ], 200);
  }

  public function synchronizeAppCoursesActive()
  {

    $response2 = Http::get($this->getBASE_URL() . "collection/cursos/active");

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

    $response3 = Http::get($this->getBASE_URL() . "api/collection/actividades/active");

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
    $response4 = Http::get($this->getBASE_URL() . "api/collection/inscritos/active");

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
      }
    }
    return response()->json([
      'success' => true,
      'error' => null
    ], 200);
  }

  public function syncronizeAppRegisteredUserActivitiesActive()
  {

    $response5 = Http::get($this->getBASE_URL() . "api/collection/inscrito-actividad/active");

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

          if (!isset($activityCourseRegisteredUserSearch)) {
            $registeredUserActivity['idinscrito'] = $courseRegisteredUserSearch->id;
            $registeredUserActivity['idacividad'] = $activitySearch->id;

            $activityCourseRegisteredUserController->store($registeredUserActivity);
          }
        }
      }
    }
    return response()->json([
      'success' => true,
      'error' => null
    ], 200);
  }
  public function syncronizeAppDaily()

  {

    $this->syncronizeAppPlatformsCategoriesDaily();
    $this->synchronizeAppCoursesActive();
    $this->syncronizeAppRegisteredUsersActive();
    $this->syncronizeAppActivitiesActive();
    $this->syncronizeAppRegisteredUserActivitiesActive();
    return response()->json([
      'success' => true,
      'error' => null
    ], 200);
  }
}
