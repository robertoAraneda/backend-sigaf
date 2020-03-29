<?php

namespace App\Http\Controllers;

use App\Models\FinalStatus;
use Illuminate\Http\Request;

class FinalStatusController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
      'description' => 'required|max:255'
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

      $finalStatuses = FinalStatus::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'finalStatuses' =>  $finalStatuses,
        'error' => null
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'finalStatuses' => null,
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

      $finalStatus = new FinalStatus();

      $finalStatus = $finalStatus->create($dataStore);

      return response()->json([
        'success' => true,
        'finalStatus' =>  $finalStatus->fresh()->format(),
        'error' => null
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'finalStatus' => null,
        'error' => $exception->getMessage()
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

        $finalStatus = FinalStatus::whereId($id)->first();

        if (isset($finalStatus)) {

          return response()->json([
            'success' => true,
            'finalStatus' =>  $finalStatus->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'finalStatus' =>  null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'finalStatus' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'finalStatus' => null,
        'error' => $exception->getMessage()
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
  public function update(Request $request, $id)
  {

    try {

      if (is_numeric($id)) {

        $dataUpdate = $this->validateData();

        $finalStatus = FinalStatus::whereId($id)->first();

        if (isset($finalStatus)) {

          $finalStatus->update($dataUpdate);

          return response()->json([
            'success' => true,
            'finalStatus' =>  $finalStatus->fresh()->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'finalStatus' =>  null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'finalStatus' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'finalStatus' => null,
        'error' => $exception->getMessage()
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

        $finalStatus = FinalStatus::whereId($id)->first();

        if (isset($finalStatus)) {

          $finalStatus->delete();

          return response()->json([
            'success' => true,
            'finalStatus' =>  null,
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'finalStatus' =>  null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'finalStatus' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'finalStatus' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }
}
