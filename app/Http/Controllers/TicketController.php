<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
      'course_registered_user_id' => 'required|integer',
      'in_out_ticket_id' => 'required|integer',
      'status_ticket_id' => 'required|integer',
      'priority_ticket_id' => 'required|integer',
      'motive_ticket_id' => 'required|integer',
      'user_create_id' => 'required|integer',
      'user_assigned_id' => 'required|integer',
      'closing_date' => 'date',
      'observation' => 'max:255',
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
      $tickets = Ticket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'data' => $tickets,
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
  public function store()
  {
    try {

      $dataStore = $this->validateData();

      $ticket = new Ticket();
      $ticket = $ticket->create($dataStore);

      return response()->json([

        'success' => true,
        'data' => $ticket->fresh()->format(),
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

        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {

          return response()->json([

            'success' => true,
            'data' => $ticket->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([

            'success' => false,
            'data' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([

          'success' => false,
          'data' => null,
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
  public function update($id)
  {
    try {
      if (is_numeric($id)) {

        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {

          $dataUpdate = $this->validateData();

          $ticket->update($dataUpdate);

          return response()->json([
            'success' => true,
            'data' => $ticket->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'data' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'data' => null,
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
        $ticket = Ticket::whereId($id)->first();

        if (isset($ticket)) {
          return response()->json([

            'success' => true,
            'data' => null,
            'error' => null
          ], 200);
        } else {
          return response()->json([

            'success' => false,
            'data' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([

          'success' => false,
          'data' => null,
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
