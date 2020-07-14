<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  protected function validateData($request)
  {
    return Validator::make($request, [
      'rut' => 'required|max:12|string',
      'name' => 'required|max:200|string',
      'phone' => 'max:12|string',
      'mobile' => 'required|max:12|string',
      'email' => 'required|max:255|email|unique:users',
      'role_id' => 'required|numeric',
      'password' => 'required|string',
      'isFirstLogin' => 'required|numeric'
    ]);
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

      $collection = new UserCollection(User::orderBy('id')
        ->get());

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
  public function store(Request $request)
  {
    //
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

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $user_id)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($user_id))
        return $this->response->badRequest();

      $userModel = User::find($user_id);

      if (!isset($userModel))
        return $this->response->noContent();

      $checkUser = User::where('email', $request->email)->first();

      if ($checkUser) {
        if ($userModel->id != $checkUser->id) {
          return $this->response->customMessageResponse('Email ya existe', 406);
        }
      }

      $userModel->rut = $request->rut;
      $userModel->name = $request->name;
      $userModel->phone = $request->phone;
      $userModel->mobile = $request->mobile;
      $userModel->email = $request->email;
      $userModel->password = bcrypt($request->password);
      $userModel->is_first_login = $request->isFirstLogin;
      $userModel->role_id = $request->role_id;
      $userModel->user_update_id = auth()->id();


      $userModel->save();

      return $this->response->success($userModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($user)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($user))
        return $this->response->badRequest();

      $userModel = User::find($user);

      if (!isset($userModel))
        return $this->response->noContent();

      $userModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
