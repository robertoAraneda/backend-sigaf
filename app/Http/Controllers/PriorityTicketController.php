<?php

namespace App\Http\Controllers;

use App\Models\PriorityTicket;
use Illuminate\Http\Request;

class PriorityTicketController extends Controller
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

      $priorityTickets = PriorityTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'priorityTickets' => $priorityTickets,
        'error' => null
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'priorityTickets' => null,
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

      $priorityTicket = new PriorityTicket();

      $priorityTicket = $priorityTicket->create($dataStore);

      return response()->json([
        'success' => true,
        'priorityTicket' => $priorityTicket->fresh()->format(),
        'error' => null
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'priorityTicket' => null,
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

        $priorityTicket = PriorityTicket::whereId($id)->first();

        if (isset($priorityTicket)) {

          return response()->json([
            'success' => true,
            'priorityTicket' => $priorityTicket->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'priorityTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'priorityTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'priorityTicket' => null,
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

        $priorityTicket = PriorityTicket::whereId($id)->first();

        if (isset($priorityTicket)) {

          $priorityTicket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'priorityTicket' => $priorityTicket->fresh()->format(),
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => true,
            'priorityTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'priorityTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'priorityTicket' => null,
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

        $priorityTicket = PriorityTicket::whereId($id)->first();

        if (isset($priorityTicket)) {

          $priorityTicket->delete();

          return response()->json([
            'success' => true,
            'priorityTicket' => null,
            'error' => null,
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'priorityTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'priorityTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'priorityTicket' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
