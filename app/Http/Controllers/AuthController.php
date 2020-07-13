<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  /**
   * Create user
   *
   * @param  [string] name
   * @param  [string] email
   * @param  [string] password
   * @param  [string] password_confirmation
   * @return [string] message
   */
  public function signup(Request $request)
  {
    $request->validate([
      'rut' => 'required',
      'name' => 'required|string',
      'mobile' => 'requiered|string',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|confirmed',
      'isFirstLogin' => 'required',
      'role_id' => 'required|numeric'
    ]);
    $user = new User([
      'rut' => $request->rut,
      'name' => $request->name,
      'phone' => $request->phone,
      'mobile' => $request->mobile,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'isFirstLogin' => $request->isFirstLogin,
      'role_id' => $request->role_id
    ]);
    $user->save();
    return response()->json([
      'message' => 'Successfully created user!'
    ], 201);
  }

  /**
   * Login user and create token
   *
   * @param  [string] email
   * @param  [string] password
   * @param  [boolean] remember_me
   * @return [string] access_token
   * @return [string] token_type
   * @return [string] expires_at
   */
  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
      'remember_me' => 'boolean'
    ]);

    $credentials = request(['email', 'password']);

    if (!Auth::attempt($credentials))

      return response()->json([
        'message' => 'Unauthorized'
      ], 401);

    $user = $request->user();

    $tokenResult = $user->createToken('Personal Access Token');

    $token = $tokenResult->token;

    if ($request->remember_me)
      $token->expires_at = Carbon::now()->addWeeks(1);

    $token->save();

    return response()->json([
      'access_token' => $tokenResult->accessToken,
      'token_type' => 'Bearer',
      'expires_at' => Carbon::parse(
        $tokenResult->token->expires_at
      )->toDateTimeString()
    ]);
  }

  /**
   * Logout user (Revoke the token)
   *
   * @return [string] message
   */
  public function logout(Request $request)
  {
    $request->user()->token()->revoke();
    return response()->json([
      'message' => 'Successfully logged out'
    ]);
  }

  /**
   * Get the authenticated User
   *
   * @return [json] user object
   */
  public function user(Request $request)
  {

    $user = $request->user();

    $searchUser = User::find($user->id);

    return response()->json([
      'user' => $searchUser->format()
    ], 200);
  }
}
