<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store($categoryMoodle)
  {
    $category = new Category();

    $category->description = $categoryMoodle['nombre'];
    $category->id_category_moodle = $categoryMoodle['idcategory'];
    $category->platform_id = $categoryMoodle['idplataforma'];
    $category->status = $categoryMoodle['active'];

    $category->save();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
