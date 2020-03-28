<?php

namespace App\Http\Controllers;

use App\Models\MotiveTicket;
use Illuminate\Http\Request;

class MotiveTicketController extends Controller
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

      $motiveTicket = MotiveTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'data' => $motiveTicket,
        'error' => null,
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => false,
        'error' => $exception->getMessage(),
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

      $dataStore = $this->validateData();

      $motiveTicket = new MotiveTicket();

      $motiveTicket = $motiveTicket->create($dataStore);

      return response()->json([
        'success' => true,
        'data' => $motiveTicket->fresh()->format(),
        'error' => null,
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => false,
        'error' => $exception->getMessage(),
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

        $motiveTicket = MotiveTicket::whereId($id)->first()->format();

        if (isset($motiveTicket)) {

          return response()->json([
            'success' => true,
            'data' => $motiveTicket,
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'data' => null,
            'error' => null,
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => false,
        'error' => $exception->getMessage(),
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

        $motiveTicket = MotiveTicket::where($id)->first();

        if (isset($motiveTicket)) {

          $motiveTicket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'data' => $motiveTicket->fresh()->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'data' => null,
            'error' => null
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => false,
        'error' => $exception->getMessage(),
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

        $motiveTicket = MotiveTicket::whereId($id)->first();

        if (isset($motiveTicket)) {

          $motiveTicket->delete();

          return response()->json([
            'success' => true,
            'data' => null,
            'error' => null,
          ], 200);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'data' => false,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
