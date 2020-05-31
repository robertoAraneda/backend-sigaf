<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
  public function fileSubmit(Request $request)
  {

    $upload_path = storage_path('app');
    $file_name = $request->file->getClientOriginalName();
    $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
    $request->file->move($upload_path,  $file_name);

    $registeredUserController = new RegisteredUserController();

    $response =  $registeredUserController->import();

    // Storage::delete('carga_alumnos.xlsx');

    return response()->json(['success' => $response]);
  }
}
