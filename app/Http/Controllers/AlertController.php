<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
      'ticket_id' => 'required|integer',
      'user_id' => 'required|integer',
      'time' => 'required',
      'date' => 'required',
      'status_reminder' => 'required|integer',
      'status_notification' => 'required|integer',
      'comment' => 'max:255'
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
      $alerts = Alert::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'data' => $alerts,
        'error' => null
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => $alerts,
        'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store()
  {
    try {
      $dataStore = $this->validateData();

      $alert = new Alert();

      $alert = $alert->create($dataStore);

      return response()->json([
        'success' => true, 'data' => $alert->fresh()->format(), 'error' => null
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false, 'data' => null, 'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      if (is_numeric($id)) {
        $alert = Alert::whereId($id)->first();

        if (isset($alert)) {

          return response()->json([
            'success' => true, 'data' => $alert->format(), 'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false, 'data' => null, 'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false, 'data' => null, 'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false, 'data' => null, 'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update($id)
  {
    try {

      if (is_numeric($id)) {

        $alert = Alert::whereId($id)->first();

        if (isset($alert)) {

          $dataUpdate = $this->validateData();

          $alert->update($dataUpdate);

          return response()->json([
            'success' => true, 'data' => $alert->format(), 'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false, 'data' => null, 'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false, 'data' => null, 'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false, 'data' => null, 'error' => $exception->getMessage()
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      if (is_numeric($id)) {
        $alert = Alert::whereId($id)->first();

        if (isset($alert)) {

          $alert->delete();

          return response()->json([
            'success' => true, 'data' => null, 'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false, 'data' => null, 'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false, 'data' => null, 'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false, 'data' => null, 'error' => $exception->getMessage()
      ], 500);
    }
  }
}
