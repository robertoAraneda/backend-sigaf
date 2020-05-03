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
   * Display a listing of platforms resources.
   *
   * @return App\Helpers\MakeResponse
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
   * Display the platform resource.
   *
   * @param  int  $platform
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Platform
   * @apiResourceModel App\Models\Platform
   * 
   * @urlParam platform required The ID of the platform resource.
   * 
   */
  public function show($platform)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($platform))
        return $this->response->badRequest();

      $platformModel = Platform::find($platform);

      if (!isset($platformModel))
        return $this->response->noContent();

      return $this->response->success($platformModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $description
   * @return Object $category
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
   * Display a list of a categories resources related to platform resource.
   *
   * @param  int  $platform
   * @return App\Helpers\MakeResponse
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
   * @urlParam platform required The ID of the platform resource.
   */
  public function categories($platform)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $platformModel = Platform::find($platform);

      if (!isset($platformModel))
        return $this->response->noContent();

      $platformFormated = new JsonPlatform($platformModel);

      $platformFormated->categories = [

        'platform' => $platformFormated,

        'relationships' =>
        [
          'links' => [
            'href' => route(
              'api.platforms.categories',
              ['platform' => $platformFormated->id],
              false
            ),

            'rel' => '/rels/categories'
          ],
          'collections' => [
            'numberOfElements' => $platformFormated->categories->count(),
            'data' => $platformFormated->categories->map(function ($category) {
              return new JsonCategory($category);
            })
          ]
        ]

      ];

      return $this->response->success($platformFormated->categories);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
