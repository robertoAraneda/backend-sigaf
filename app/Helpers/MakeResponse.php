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
      'statusCode' => 200,
      'message' => 'Consulta exitosa.'
    ], 200);
  }

  public static function created($data)
  {
    return response()->json([
      'success' => true,
      'data' => $data,
      'error' => null,
      'statusCode' => 201,
      'message' => 'Registro creado exitosamente.'
    ], 201);
  }
  public static function exception($exception)
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => $exception,
      'statusCode' => 500,
      'message' => 'Error de grave. Contacte al administrador.'
    ], 500);
  }
  public static function unauthorized()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Unauthorized.',
      'statusCode' => 401,
      'message' => 'Sin autorización.'
    ], 401);
  }
  public static function badRequest()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Malformed URL.',
      'statusCode' => 400,
      'message' => 'Url no corresponde.'
    ], 400);
  }
  public static function noContent()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'No content',
      'statusCode' => 204,
      'message' => 'Registro no encontrado'
    ], 200);
  }
}
