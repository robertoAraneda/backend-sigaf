<?php

namespace App\Http\Controllers;

use App\Imports\RegisteredUserImport;
use App\Models\RegisteredUser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RegisteredUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store($registeredUserMoodle)
  {
    $registeredUser = new RegisteredUser();

    $registeredUser->id_registered_moodle = $registeredUserMoodle['iduser'];
    $registeredUser->rut_registered_moodle = $registeredUserMoodle['rut'];
    $registeredUser->name_registered_moodle = $registeredUserMoodle['nombre'];
    $registeredUser->email_registered_moodle = $registeredUserMoodle['email'];
    $registeredUser->status_moodle = $registeredUserMoodle['activo'];

    $registeredUser->save();

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])->first();

    return $registeredUser;
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

  public function findByIdRegisteredUserMoodle($idRegisteredUserMoodle)
  {
    $registeredUser = RegisteredUser::where('id_registered_moodle', $idRegisteredUserMoodle)->first();

    return $registeredUser;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update($id, $registeredUserMoodle)
  {
    $registeredUser = RegisteredUser::whereId($id)->first();

    $registeredUser->id_registered_moodle = $registeredUserMoodle['iduser'];
    $registeredUser->rut_registered_moodle = $registeredUserMoodle['rut'];
    $registeredUser->name_registered_moodle = $registeredUserMoodle['nombre'];
    $registeredUser->email_registered_moodle = $registeredUserMoodle['email'];
    $registeredUser->status_moodle = $registeredUserMoodle['activo'];

    $registeredUser->save();

    $registeredUser = RegisteredUser::where('id_registered_moodle',  $registeredUserMoodle['iduser'])->first();

    return $registeredUser;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function import()
  {
    //$excel =  Excel::import(new RegisteredUserImport, 'D:\Proyectos\inacap-iie\importFile\prueba.xlsx');
    $collection = (new RegisteredUserImport)->toCollection('D:\Proyectos\inacap-iie\importFile\prueba.xlsx');

    $array = [];
    foreach ($collection as $value) {
      foreach ($value as $key) {
        $array[] = array(
          'rut' => $key[0],
          'nombre' => $key[1],
          'last_name' => $key[2],
          'mother_last_name' => $key[3]
        );
      }
    }

    return $array;


    // return redirect('/')->with('success', 'All good!');
  }
}
