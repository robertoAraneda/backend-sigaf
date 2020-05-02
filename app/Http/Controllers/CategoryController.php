<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Http\Resources\Json\Course as JsonCourse;
use App\Http\Resources\Json\Category as JsonCategory;

class CategoryController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
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

      $collection = new CategoryCollection(Category::orderBy('id')->get());

      if (!isset($collection))
        return $this->response->noContent();

      return $this->response->success($collection);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

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

  public function findByIdCategoryMoodle($idCategoryMoodle)
  {
    $category = Category::where('id_category_moodle', $idCategoryMoodle)->first();

    return $category;
  }

  public function findByIdPlatformAndCategoryMoodle($idCategoryMoodle, $idPlatform)
  {

    $category = Category::where('id_category_moodle', $idCategoryMoodle)->where('platform_id', $idPlatform)->first();

    return $category;
  }


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


  public function destroy($id)
  {
    //
  }

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
            'href' => route('api.categories.courses', ['id' => $model->id], false),
            'rel' => '/rels/courses',
          ],
          'quantity' => $model->courses->count(),
          'collection' => $model->courses->map(function ($course) {
            return new JsonCourse($course);
          })
        ]
      ];

      return $this->response->success($model->courses);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
