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
   * Display a listing of categories resources.
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
   * Display the category resource.
   *
   * @param  int  $category
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Category
   * @apiResourceModel App\Models\Category
   * 
   * @urlParam category required The ID of the category resource.
   */
  public function show($category)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($category))
        return $this->response->badRequest();

      $categoryModel = Category::find($category);

      if (!isset($categoryModel))
        return $this->response->noContent();

      return $this->response->success($categoryModel->format());
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
   * Display a list of courses resources related to category resource.
   *
   * @param  int  $category
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
   * @urlParam category required The ID of the category resource.
   */
  public function courses($category)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $categoryModel = Category::find($category);

      if (!isset($categoryModel))
        return $this->response->noContent();

      $categoryFormated = new JsonCategory($categoryModel);

      $categoryFormated->courses = [
        'category' => $categoryFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.categories.courses',
              ['category' => $categoryFormated->id],
              false
            ),
            'rel' => '/rels/courses',
          ],

          'collections' => [
            'numberOfElements' => $categoryFormated->courses->count(),
            'data' => $categoryFormated->courses->map(function ($course) {
              return new JsonCourse($course);
            })
          ]
        ]
      ];

      return $this->response->success($categoryFormated->courses);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
