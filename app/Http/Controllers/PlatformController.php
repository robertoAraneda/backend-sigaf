<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
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
  public function store($platformMoodle)
  {
    $platform = new Platform();

    $platform->description = $platformMoodle['nombre'];

    $platform->save();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function findByDescription($description)
  {

    $platform = Platform::where('description', $description)->first();

    return $platform;
  }

  public function update($id, $platformMoodle)
  {
    $platform = Platform::whereId($id)->first();

    $platform->description = $platformMoodle['nombre'];

    $platform->save();
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
}
