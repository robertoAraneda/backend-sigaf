<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Http\Resources\Json\Category as JsonCategory;

class CategoryController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse)
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

      $categories = new CategoryCollection(category::all());

      if (!isset($categories))
        return $this->response->noContent();

      return $this->response->success($categories);
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

      return $this->response->success(new JsonCategory($category));
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

  public function courses($idCategory)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $category = new JsonCategory(Category::find($idCategory));

      $category->courses = [
        'url' => route('api.categories.courses', ['category' => $category->id]),
        'href' => route('api.categories.courses', ['category' => $category->id], false),
        'rel' => class_basename($category->courses()->getRelated()),
        'count' => $category->courses->count(),
        'category' => $category,
        'courses' => $category->courses->map(function ($category) {
          return new JsonCategory($category);
        })
      ];

      return $this->response->success($category->courses);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
