<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\Role as JsonRole;
use App\Http\Resources\Json\User as JsonUser;
use App\Http\Resources\RoleCollection;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
   * Display a listing of the roles resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\RoleCollection
   * @apiResourceModel App\Models\Role
   */
  public function index()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      $roles = new RoleCollection(Role::all());

      return $this->response->success($roles);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Role
   * @apiResourceModel App\Models\Role
   */
  public function store()
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $role = new Role();

      $role = $role->create(request()->all());

      return $this->response->created($role->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $role
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Role
   * @apiResourceModel App\Models\Role
   * 
   * @urlParam role required The ID of the role resource.
   */
  public function show($role)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      if (!is_numeric($role))
        return $this->response->badRequest();

      $roleModel = Role::find($role);

      if (!isset($roleModel))
        return $this->response->noContent();

      return $this->response->success($roleModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $role
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\Role
   * @apiResourceModel App\Models\Role
   * 
   * @urlParam role required The ID of the role resource.
   */
  public function update($role)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      if (!is_numeric($role))
        return $this->response->badRequest();

      $roleModel = Role::find($role);

      if (!isset($roleModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $roleModel->update(request()->all());

      return $this->response->success($roleModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam role required The ID of the role resource   
   */
  public function destroy($role)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      if (!is_numeric($role))
        return $this->response->badRequest();

      $roleModel = Role::find($role);

      if (!isset($roleModel))
        return $this->response->noContent();

      $roleModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of users resources related to role resource.
   *
   * @param  int  $role
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "role": "role",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam type_ticket required The ID of the type ticket resource.
   */
  public function users($role)
  {
    try {

      if (!request()->isJson())
        return $this->response->unauthotized();

      if (!is_numeric($role))
        return $this->response->badRequest();

      $roleModel = Role::find($role);

      if (!isset($roleModel))
        return $this->response->noContent();

      $roleFormated = new JsonRole($roleModel);

      $roleFormated->users = [
        'role' => $roleFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.roles.users',
              ['role' => $roleFormated->id],
              false
            ),
            'rel' => '/rels/users'
          ],
          'collection' => [
            'numberOfElements' => $roleFormated->users->count(),
            'data' => $roleFormated->users->map(function ($user) {
              return new JsonUser($user);
            })
          ]
        ]
      ];

      return $this->response->success($roleFormated->users);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
