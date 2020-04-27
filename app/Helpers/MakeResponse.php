<?php

namespace App\Helpers;

class MakeResponse
{

  public static function success($data)
  {
    return response()->json([
      'success' => true,
      'data' => $data,
      'error' => null,
      'statusCode' => 200
    ]);
  }
  public static function exception($exception)
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => $exception,
      'statusCode' => 500
    ]);
  }
  public static function unauthorized()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Sin autorización',
      'statusCode' => 401
    ]);
  }
  public static function badRequest()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Url mal formada. Detente!!',
      'statusCode' => 400
    ]);
  }
  public static function noContent()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Elemento no encontrado',
      'statusCode' => 204
    ]);
  }
}
