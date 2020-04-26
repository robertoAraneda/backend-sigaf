<?php

namespace App\Http\Controllers;

use App\Models\TypeTicket;
use Illuminate\Http\Request;

class TypeTicketController extends Controller
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
      $typeTickets = TypeTicket::orderBy('id')
        ->get()
        ->map
        ->format();

      return response()->json([
        'success' => true,
        'typeTickets' => $typeTickets,
        'error' => null
      ], 200);
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'typeTickets' => null,
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
      $typeTicket = new TypeTicket();
      $typeTicket = $typeTicket->create($dataStore);

      return response()->json([
        'success' => true,
        'typeTickets' => $typeTicket->fresh()->format(),
        'error' => null

      ], 201);
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'typeTicket' => null,
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

        $typeTicket = TypeTicket::whereId($id)->first();

        if (isset($typeTicket)) {

          return response()->json([
            'success' => true,
            'typeTicket' => $typeTicket->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'typeTicket' => null,
            'error' => 'No Content',
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'typeTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'typeTicket' => null,
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

        $typeTicket = TypeTicket::whereId($id)->first();

        if (isset($typeTicket)) {

          $typeTicket->update($dataUpdate);
          // $typeTicket->description = $request->description;

          // $typeTicket->save();

          return response()->json([
            'success' => true,
            'typeTicket' => $typeTicket->fresh()->format(),
            'error' => null
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'typeTicket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'typeTicket' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'typeTicket' => null,
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

        $typeTicket = TypeTicket::whereId($id)->first();

        if (isset($typeTicket)) {

          $typeTicket->delete();

          return response()->json([
            'success' => true,
            'typeTicket' => null,
            'error' => null,
          ], 200);
        } else {

          return response()->json([
            'success' => false,
            'typeTicket' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {

        return response()->json([
          'success' => false,
          'typeTicket' => null,
          'error' => 'Bad Request',
        ], 400);
      }
    } catch (\Exception $exception) {

      return response()->json([
        'success' => false,
        'typeTicket' => null,
        'error' => $exception->getMessage(),
      ], 500);
    }
  }
}
