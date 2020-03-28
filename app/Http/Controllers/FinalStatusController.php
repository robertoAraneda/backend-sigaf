<?php

namespace App\Http\Controllers;

use App\Models\FinalStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinalStatusController extends Controller
{
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
        ->map(function ($finalStatus) {
          return [
            'id' => $finalStatus->id,
            'description' => $finalStatus->description,
            'created_at' => Carbon::parse($finalStatus->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($finalStatus->updated_at)->diffForHumans()
          ];
        });

      return response()->json([
        'success' => true,
        'data' =>  $finalStatuses,
        'error' => null
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => null,
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
  public function store(Request $request)
  {

    try {

      $request->validate([
        'description' => 'required|max:255'
      ]);

      $finalStatus = new FinalStatus();
      $finalStatus->description = $request->description;


      $finalStatus->save();

      return response()->json([
        'success' => true,
        'data' =>  $finalStatus->fresh(),
        'error' => null
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => null,
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
            'data' =>  $finalStatus,
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'data' =>  null,
            'error' => null
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => null,
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

      $request->validate([
        'description' => 'required|max:255'
      ]);

      if (is_numeric($id)) {

        $finalStatus = FinalStatus::whereId($id)->first();

        if (isset($finalStatus)) {

          $finalStatus->description = $request->description;

          $finalStatus->save();

          return response()->json([
            'success' => true,
            'data' =>  $finalStatus->fresh(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'data' =>  null,
            'error' => null
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => null,
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

          $finalStatus = FinalStatus::whereId($id)->first();

          $finalStatus->delete();

          return response()->json([
            'success' => true,
            'data' =>  null,
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'data' =>  null,
            'error' => null
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' =>  null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }
}
