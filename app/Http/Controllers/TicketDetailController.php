<?php

namespace App\Http\Controllers;

use App\Models\TicketDetail;
use App\Helpers\MakeResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TicketDetailCollection;

class TicketDetailController extends Controller
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

      if (!request()->isJson())
        return $this->response->unauthorized();

      $ticketDetail = new TicketDetailCollection(TicketDetail::orderBy('created_at', 'asc')->get());

      return $this->response->success($ticketDetail);
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

      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $ticketDetail = new TicketDetail();

      $ticketDetail = $ticketDetail->create(request()->all());

      return $this->response->created($ticketDetail->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($ticket_detail)
  {

    try {

      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($ticket_detail))
        return $this->response->badRequest();

      $ticketDetailModel = TicketDetail::find($ticket_detail);

      if (!isset($ticketDetailModel))
        return $this->response->noContent();

      return $this->response->success($ticketDetailModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
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

          $dataUpdate = $this->validateData(request()->all());
          // $ticketDetail->ticket_id = $updateData['ticket_id'];
          // $ticketDetail->user_create_id = $updateData['user_created_id'];
          // $ticketDetail->status_detail_ticket_id = $updateData['status_detail_ticket_id'];
          // $ticketDetail->comment = $updateData['comment'];

          // $ticketDetail->save();

          $ticketDetail->update($dataUpdate);

          return response()->json([
            'success' => true,
            'ticketDetail' => $ticketDetail->fresh()->format(),
            'error' => null
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'ticketDetail' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([
          'success' => false,
          'ticketDetail' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'ticketDetail' => null,
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
            'ticketDetail' => null,
            'error' => null
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'ticketDetail' => null,
            'error' => 'No Content'
          ], 204);
        }
      } else {
        return response()->json([
          'success' => false,
          'ticketDetail' => null,
          'error' => 'Bad Request'
        ], 400);
      }
    } catch (\Exception $exception) {
      return response()->json([
        'success' => false,
        'ticketDetail' => null,
        'error' => $exception->getMessage()
      ], 500);
    }
  }
}
