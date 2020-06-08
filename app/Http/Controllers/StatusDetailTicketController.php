<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Models\StatusDetailTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StatusDetailTicketCollection;

class StatusDetailTicketController extends Controller
{

  /**
   * Property for make a response.
   *
   * @var  App\Helpers\MakeResponse  $response
   */
  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

  /**
   * Validate the description field.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  protected function validateData($request)
  {
    return Validator::make($request, [
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

      if (!request()->isJson())
        return $this->response->unauthorized();

      $statusDetailTicket = new StatusDetailTicketCollection(StatusDetailTicket::all());

      return $this->response->success($statusDetailTicket);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
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

      $dataStore = $this->validateData(request()->all());

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

        $dataUpdate = $this->validateData(request()->all());

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
