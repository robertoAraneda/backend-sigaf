<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\CourseRegisteredUser as JsonCourseRegisteredUser;
use App\Http\Resources\Json\Profile as JsonProfile;
use App\Http\Resources\ProfileCollection;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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
   * Display a listing of the profile resource.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\ProfileCollection
   * @apiResourceModel App\Models\Profile
   */
  public function index()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $profiles = new ProfileCollection(Profile::all());

      return $this->response->success($profiles);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Profile
   * @apiResourceModel App\Models\Profile
   */
  public function store()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $profile = new Profile();

      $profile = $profile->create(request()->all());

      return $this->response->success($profile->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $profile
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Profile
   * @apiResourceModel App\Models\Profile
   * 
   * @urlParam profile required The ID of the profile resource.
   */
  public function show($profile)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($profile))
        return $this->response->badRequest();

      $profileModel = Profile::find($profile);

      if (!isset($profileModel))
        return $this->response->noContent();

      return $this->response->success($profileModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $profile
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Profile
   * @apiResourceModel App\Models\Profile
   * 
   * @urlParam profile required The ID of the profile resource.
   */
  public function update($profile)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($profile))
        return $this->response->badRequest();

      $profileModel = Profile::find($profile);

      if (!isset($profileModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $profileModel->update(request()->all());

      return $this->response->success($profileModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $profile
   *  @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Profile
   * @apiResourceModel App\Models\Profile
   * 
   * @urlParam profile required The ID of the profile resource.
   */
  public function destroy($profile)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($profile))
        return $this->response->badRequest();

      $profileModel = Profile::find($profile);

      if (!isset($profileModel))
        return $this->response->noContent();

      $profileModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of course registered users resources related to profiles resource.
   *
   * @param  int  $profile
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
   * @urlParam profile required The ID of the profile resource.
   */
  public function courseRegisteredUsers($profile)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $profileModel = Profile::find($profile);

      if (!isset($profileModel))
        return $this->response->noContent();

      $profileFormated = new JsonProfile($profileModel);

      $profileFormated->courseRegisteredUsers = [
        'profiles' => $profileFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.profiles.courseRegisteredUsers',
              ['profile' => $profileFormated->id],
              false
            ),
            'rel' => '/rels/courseRegisteredUsers'
          ],
          'collection' => [
            'numberOfElements' => $profileFormated->courseRegisteredUsers->count(),
            'data' => $profileFormated->courseRegisteredUsers->map(function ($courseRegisteredUser) {
              return new JsonCourseRegisteredUser($courseRegisteredUser);
            })
          ]
        ]
      ];

      return $this->response->success($profileFormated->courseRegisteredUsers);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
