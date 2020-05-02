<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Platform;
use App\Http\Resources\Json\Platform as JsonPlatform;
use App\Http\Resources\Json\Category as JsonCategory;
use App\Http\Resources\PlatformCollection;


class PlatformController extends Controller
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

      $collection = new PlatformCollection(Platform::orderBy('id')->get());

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
  public function store($platformMoodle)
  {
    $platform = new Platform();

    $platform->description = $platformMoodle['nombre'];

    $platform->save();
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

      $model = Platform::find($id);

      if (!isset($model))
        return $this->response->noContent();

      return $this->response->success(new JsonPlatform($model));
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function findByDescription($description)
  {

    $platform = Platform::where('description', $description)->first();

    return $platform;
  }

  public function update($id, $platformMoodle)
  {
    $platform = Platform::whereId($id)->first();

    $platform->description = $platformMoodle['nombre'];

    $platform->save();
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

  public function categories($id)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $model = new JsonPlatform(Platform::find($id));

      $model->categories = [
        'platform' => $model,

        'href' => route('api.platforms.categories', ['id' => $model->id], false),

        'rel' => '/rels/categories',

        'quantity' => $model->categories->count(),

        'categories' => $model->categories->map(function ($category) {
          return new JsonCategory($category);
        })
      ];

      return $this->response->success($model->categories);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
