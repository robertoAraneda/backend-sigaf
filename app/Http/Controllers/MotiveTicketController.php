<?php

namespace App\Http\Controllers;

use App\Models\MotiveTicket;
use Illuminate\Http\Request;

class MotiveTicketController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
      'description' => 'required|max:25'
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

      $motiveTickets = MotiveTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'motiveTickets' => $motiveTickets,
        'error' => null,
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'motiveTickets' => null,
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
  public function store()
  {

    try {

      $dataStore = $this->validateData();

      $motiveTicket = new MotiveTicket();

      $motiveTicket = $motiveTicket->create($dataStore);

      return response()->json([
        'success' => true,
        'motiveTicket' => $motiveTicket->fresh()->format(),
        'error' => null,
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'motiveTicket' => null,
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

        $motiveTicket = MotiveTicket::whereId($id)->first();

        if (isset($motiveTicket)) {

          return response()->json([
            'success' => true,
            'motiveTicket' => $motiveTicket->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'motiveTicket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'motiveTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'motiveTicket' => null,
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

        $motiveTicket = MotiveTicket::whereId($id)->first();

        if (isset($motiveTicket)) {

          $motiveTicket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'motiveTicket' => $motiveTicket->fresh()->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'motiveTicket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'motiveTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'motiveTicket' => null,
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
            'motiveTicket' => null,
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'motiveTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'motiveTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'motiveTicket' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
