<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\FinalStatusCollection;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use App\Http\Resources\Json\FinalStatus as JsonFinalStatus;
use App\Models\FinalStatus;
use Illuminate\Support\Facades\Validator;

class FinalStatusController extends Controller
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
   * Validate the description field.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  protected function validateData($request)
  {
    return Validator::make($request, [
      'description' => 'required|max:25'
    ]);
  }

  /**
   * Display a listing of the final statuses resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\FinalStatusCollection
   * @apiResourceModel App\Models\FinalStatus
   */
  public function index()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $finalStatuses = new FinalStatusCollection(FinalStatus::all());

      return $this->response->success($finalStatuses);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\FinalStatus
   * @apiResourceModel App\Models\FinalStatus
   */
  public function store()
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $finalStatus = new FinalStatus();

      $finalStatus = $finalStatus->create(request()->all());

      return $this->response->created($finalStatus->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $final_status
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\FinalStatus
   * @apiResourceModel App\Models\FinalStatus
   * 
   * @urlParam final_status required The ID of the final status resource.
   */
  public function show($final_status)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($final_status))
        return $this->response->badRequest();

      $finalStatusModel = FinalStatus::find($final_status);

      if (!isset($finalStatusModel))
        return $this->response->noContent();

      return $this->response->success($finalStatusModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $final_status
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\FinalStatus
   * @apiResourceModel App\Models\FinalStatus
   * 
   * @urlParam final_status required The ID of the final status resource.
   */
  public function update($final_status)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($final_status))
        return $this->response->badRequest();

      $finalStatusModel = FinalStatus::find($final_status);

      if (!isset($finalStatusModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $finalStatusModel->update(request()->all());

      return $this->response->success($finalStatusModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $final_status
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam final_status required The ID of the final status resource.
   */
  public function destroy($final_status)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($final_status))
        return $this->response->badRequest();

      $finalStatusModel = FinalStatus::find($final_status);

      if (!isset($finalStatusModel))
        return $this->response->noContent();

      $finalStatusModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of course registered users resources related to final status resource.
   *
   * @param  int  $final_status
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "finalStatus": "finalStatus",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam final_status required The ID of the final status resource.
   */
  public function courseRegisteredUsers($final_status)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($final_status))
        return $this->response->badRequest();

      $finalStatusModel = FinalStatus::find($final_status);

      if (!isset($finalStatusModel))
        return $this->response->noContent();

      $finalStatusFormated = new JsonFinalStatus($finalStatusModel);

      $finalStatusFormated->courseRegisteredUsers = [
        'finalStatus' => $finalStatusFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.finalStatuses.courseRegisteredUsers',
              ['final_status' => $finalStatusFormated->id],
              false
            ),
            'rel' => '/rels/courseRegisteredUsers'
          ],
          'collection' => [
            'numberOfElements' => $finalStatusFormated->courseRegisteredUsers->count(),
            'data' => $finalStatusFormated->courseRegisteredUsers->map(function ($courseRegisteredUser) {
              return new JsonCourseRegisteredUser($courseRegisteredUser);
            })
          ]
        ]
      ];

      return $this->response->success($finalStatusFormated->courseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
