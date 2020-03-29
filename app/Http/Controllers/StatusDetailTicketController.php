<?php

namespace App\Http\Controllers;

use App\Models\StatusDetailTicket;
use Illuminate\Http\Request;

class StatusDetailTicketController extends Controller
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

      $statusDetailTickets = StatusDetailTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'statusDetailTickets' => $statusDetailTickets,
        'error' => null,
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'statusDetailTickets' => null,
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

      $statusDetailTicket = new StatusDetailTicket();

      $statusDetailTicket = $statusDetailTicket->create($dataStore);

      return response()->json([
        'success' => true,
        'statusDetailTicket' => $statusDetailTicket->fresh()->format(),
        'error' => null,
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'statusDetailTicket' => null,
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

        $statusDetailTicket = StatusDetailTicket::whereId($id)->first();

        if (isset($statusDetailTicket)) {

          return response()->json([
            'success' => true,
            'statusDetailTicket' => $statusDetailTicket->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'statusDetailTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'statusDetailTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'statusDetailTicket' => null,
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

        $statusDetailTicket = StatusDetailTicket::whereId($id)->first();

        if (isset($statusDetailTicket)) {

          $statusDetailTicket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'statusDetailTicket' => $statusDetailTicket->fresh()->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'statusDetailTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'statusDetailTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'statusDetailTicket' => null,
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

        $statusDetailTicket = StatusDetailTicket::whereId($id)->first();

        if (isset($statusDetailTicket)) {

          $statusDetailTicket->delete();

          return response()->json([
            'success' => true,
            'statusDetailTicket' => null,
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'statusDetailTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'statusDetailTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'statusDetailTicket' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
