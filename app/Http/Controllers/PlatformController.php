<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\Platform;
use App\Http\Resources\Json\Platform as JsonPlatform;
use App\Http\Resources\Json\Category as JsonCategory;
use App\Http\Resources\PlatformCollection;

/**
 * @group Platform management
 */
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
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\PlatformCollection
   * @apiResourceModel App\Models\Platform
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
   * Display the platform.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   * 
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Platform
   * @apiResourceModel App\Models\Platform
   * 
   * @urlParam platform required The ID of the platform.
   * 
   */
  public function show($platform)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($platform))
        return $this->response->badRequest();

      $model = Platform::find($platform);

      if (!isset($model))
        return $this->response->noContent();

      return $this->response->success($model->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $description
   * @return \Illuminate\Http\Response
   */
  public function findByDescription($description)
  {

    $platform = Platform::where('description', $description)->first();

    return $platform;
  }

  /**
   * Updated the specified resource.
   *
   * @param  int  $id
   * @param  int  $platformMoodle
   */
  public function update($id, $platformMoodle)
  {
    $platform = Platform::whereId($id)->first();

    $platform->description = $platformMoodle['nombre'];

    $platform->save();
  }

  /**
   * Display a list of a categories from platform.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   * 
   * @authenticated 
   * @response {
   *  "platform": "platform",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/categories"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam platform required The ID of the platform.
   */
  public function categories($platform)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $checkModel = Platform::find($platform);

      if (!isset($checkModel))
        return $this->response->noContent();

      $model = new JsonPlatform($checkModel);

      $model->categories = [

        'platform' => $model,

        'relationships' =>
        [
          'links' => [
            'href' => route(
              'api.platforms.categories',
              ['platform' => $model->id],
              false
            ),

            'rel' => '/rels/categories'
          ],
          'collections' => [
            'numberOfElements' => $model->categories->count(),
            'data' => $model->categories->map(function ($category) {
              return new JsonCategory($category);
            })
          ]
        ]

      ];

      return $this->response->success($model->categories);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
