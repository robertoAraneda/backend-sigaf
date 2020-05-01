<?php

namespace App\Helpers;

class MakeResponse
{

  public function success($data)
  {
    return response()->json([
      'success' => true,
      'error' => null,
      'statusCode' => 200,
      'message' => 'Consulta exitosa.',
      'data' => $data
    ], 200);
  }

  public function created($data)
  {
    return response()->json([
      'success' => true,
      'data' => $data,
      'error' => null,
      'statusCode' => 201,
      'message' => 'Registro creado exitosamente.'
    ], 201);
  }
  public function exception($exception)
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => $exception,
      'statusCode' => 500,
      'message' => 'Error de grave. Contacte al administrador.'
    ], 500);
  }
  public function unauthorized()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Unauthorized.',
      'statusCode' => 401,
      'message' => 'Sin autorización.'
    ], 401);
  }
  public function badRequest()
  {
    return response()->json([
      'success' => false,
      'data' => null,
      'error' => 'Malformed URL.',
      'statusCode' => 400,
      'message' => 'Url no corresponde.'
    ], 400);
  }
  public function noContent()
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
