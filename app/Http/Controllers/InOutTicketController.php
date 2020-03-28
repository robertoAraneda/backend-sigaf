<?php

namespace App\Http\Controllers;

use App\Models\InOutTicket;
use Illuminate\Http\Request;

class InOutTicketController extends Controller
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

      $inOutTickets = InOutTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'data' => $inOutTickets,
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

      $dataStore = $this->validateData();

      $inOutTicket = new InOutTicket();

      $inOutTicket = $inOutTicket->create($dataStore);
      // $inOutTicket->description = $request->description;

      // $inOutTicket->save();
      return response()->json([
        'success' => true,
        'data' => $inOutTicket->fresh()->format(),
        'error' => null
      ], 201);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => true,
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

        $inOutTicket = InOutTicket::whereId($id)->first()->format();

        if (isset($inOutTicket)) {

          return response()->json([
            'success' => true,
            'data' => $inOutTicket,
            'error' => null
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
        'success' => true,
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

      if (is_numeric($id)) {

        $dataUpdate = $this->validateData();

        $inOutTicket = InOutTicket::whereId($id)->first();

        if (isset($inOutTicket)) {

          $inOutTicket->update($dataUpdate);
          // $inOutTicket->description = $request->description;

          // $inOutTicket->save();

          return response()->json([
            'success' => true,
            'data' => $inOutTicket->fresh()->format(),
            'error' => null
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

        $inOutTicket = InOutTicket::whereId($id)->first();

        if (isset($inOutTicket)) {

          $inOutTicket = InOutTicket::whereId($id)->first();

          $inOutTicket->delete();

          return response()->json([
            'success' => true,
            'data' => null,
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
        'data' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
