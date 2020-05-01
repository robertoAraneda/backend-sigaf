<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;

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
    //
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
}
