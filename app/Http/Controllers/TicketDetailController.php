<?php

namespace App\Http\Controllers;

use App\Models\TicketDetail;
use Illuminate\Http\Request;

class TicketDetailController extends Controller
{

  protected function validateData()
  {
    return request()->validate([
      'ticket_id' => 'required|integer',
      'user_created_id' => 'required|integer',
      'status_detail_ticket_id' => 'required|integer',
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

      $ticketDetails = TicketDetail::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([

        'success' => true,
        'data' => $ticketDetails,
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

      $ticketDetail = new TicketDetail();

      $ticketDetail =  $ticketDetail->create($dataStore);

      // $ticketDetail->ticket_id = $dataStore['ticket_id'];
      // $ticketDetail->user_create_id = $dataStore['user_created_id'];
      // $ticketDetail->status_detail_ticket_id = $dataStore['status_detail_ticket_id'];
      // $ticketDetail->comment = $dataStore['comment'];

      // $ticketDetail->save();

      return response()->json([
        'success' => true,
        'data' => $ticketDetail->fresh()->format(),
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

        $ticketDetail = TicketDetail::whereId($id)->first();

        if (isset($ticketDetail)) {

          return response()->json([
            'success' => true,
            'data' => $ticketDetail->format(),
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


        $ticketDetail = TicketDetail::whereId($id)->first();

        if (isset($ticketDetail)) {

          $dataUpdate = $this->validateData();
          // $ticketDetail->ticket_id = $updateData['ticket_id'];
          // $ticketDetail->user_create_id = $updateData['user_created_id'];
          // $ticketDetail->status_detail_ticket_id = $updateData['status_detail_ticket_id'];
          // $ticketDetail->comment = $updateData['comment'];

          // $ticketDetail->save();

          $ticketDetail->update($dataUpdate);

          return response()->json([
            'success' => true,
            'data' => $ticketDetail->fresh()->format(),
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

        $ticketDetail = TicketDetail::whereId($id)->first();

        if (isset($ticketDetail)) {

          $ticketDetail->delete();

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
