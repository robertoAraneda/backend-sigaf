<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\Category as JsonCategory;

/**
 * @group Category management
 */
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
   * Display a listing of Categories.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\CategoryCollection
   * @apiResourceModel App\Models\Category
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
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Category
   * @apiResourceModel App\Models\Category
   * 
   * @urlParam category required The ID of the platform.
   */
  public function show($category)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($category))
        return $this->response->badRequest();

      $getModel = Category::find($category);

      if (!isset($getModel))
        return $this->response->noContent();

      return $this->response->success($getModel->format());
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
   * Display a list of courses related to Category.
   *
   * @param  int  $id
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "category": "category",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/courses"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam category required The ID of the Category.
   */
  public function courses($category)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = Category::find($category);

      if (!isset($checkModel))
        return $this->response->noContent();

      $getModel = new JsonCategory($checkModel);

      $getModel->getModelcourses = [
        'category' => $getModel,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.categories.courses',
              ['category' => $getModel->id],
              false
            ),
            'rel' => '/rels/courses',
          ],

          'collection' => [
            'numberOfElements' => $getModel->courses->count(),
            'data' => $getModel->courses->map(function ($course) {
              return new JsonCourse($course);
            })
          ]
        ]
      ];

      return $this->response->success($getModel->courses);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
