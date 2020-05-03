<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\Category as JsonCategory;

class CategoryController extends Controller
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
   * Display a listing of the resource.
   *
   * @return App\Helpers\MakeResponse
   */
  public function index()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $collection = new CategoryCollection(Category::orderBy('id')->get());

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
   * @param  Object $categoryMoodle
   * @return Object $category
   */
  public function store($categoryMoodle)
  {
    $category = new Category();

    $category->description = $categoryMoodle['nombre'];
    $category->id_category_moodle = $categoryMoodle['idcategory'];
    $category->platform_id = $categoryMoodle['idplataforma'];
    $category->status = $categoryMoodle['active'];

    $category->save();

    return $category;
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return App\Helpers\MakeResponse
   */
  public function show($id)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($id))
        return $this->response->badRequest();

      $category = Category::find($id);

      if (!isset($category))
        return $this->response->noContent();

      return $this->response->success($category->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $idCategoryMoodle
   * @return Object $category
   */
  public function findByIdCategoryMoodle($idCategoryMoodle)
  {
    $category = Category::where('id_category_moodle', $idCategoryMoodle)
      ->first();

    return $category;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $idCategoryMoodle
   * @param  int  $idPlatform
   * @return Object $category
   */
  public function findByIdPlatformAndCategoryMoodle($idCategoryMoodle, $idPlatform)
  {

    $category = Category::where('id_category_moodle', $idCategoryMoodle)
      ->where('platform_id', $idPlatform)
      ->first();

    return $category;
  }

  /**
   * Updated the specified resource.
   *
   * @param  int  $id
   * @param  int  $categoryMoodle
   * @return Object $category
   */
  public function update($id, $categoryMoodle)
  {

    $category = Category::whereId($id)->first();

    $category->description = $categoryMoodle['nombre'];
    $category->id_category_moodle = $categoryMoodle['idcategory'];
    $category->platform_id = $categoryMoodle['idplataforma'];
    $category->status = $categoryMoodle['active'];

    $category->save();

    return $category;
  }


  /**
   * Display a list of courses.
   *
   * @param  int  $id
   * @return App\Helpers\MakeResponse
   */
  public function courses($id)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = Category::find($id);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonCategory($checkModel);

      $model->courses = [
        'category' => $model,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.categories.courses',
              ['category' => $model->id],
              false
            ),
            'rel' => '/rels/courses',
          ],

          'collection' => [
            'numberOfElements' => $model->courses->count(),
            'data' => $model->courses->map(function ($course) {
              return new JsonCourse($course);
            })
          ]
        ]
      ];

      return $this->response->success($model->courses);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
