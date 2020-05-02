<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\StatusTicket as JsonStatusTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\StatusTicketCollection;
use App\Models\StatusTicket;
use Illuminate\Support\Facades\Validator;

class StatusTicketController extends Controller
{
  protected $response;

  public function __construct(MakeResponse $makeResponse = null)
  {
    $this->response = $makeResponse;
  }

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

      $statusTickets = new StatusTicketCollection(StatusTicket::all());

      return $this->response->success($statusTickets);
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

      $statusTicket = new StatusTicket();

      $statusTicket = $statusTicket->create(request()->all());

      return $this->response->created(new JsonStatusTicket($statusTicket));
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
  public function show($id)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (is_numeric($id))
        return $this->response->badRequest();

      $statusTicket = StatusTicket::find($id);

      if (!isset($statusTicket))
        return $this->response->noContent();

      return $this->response->success($statusTicket->format());
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
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (is_numeric($id))
        return $this->response->badRequest();

      $statusTicket = StatusTicket::find($id);

      if (!isset($statusTicket))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $statusTicket->update(request()->all());

      return $this->response->success(new JsonStatusTicket($statusTicket->fresh()));
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
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
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (is_numeric($id))
        return $this->response->badRequest();

      $statusTicket = StatusTicket::find($id);

      if (!isset($statusTicket))
        return $this->response->noContent();

      $statusTicket->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function tickets($idStatusTicket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $statusTicket = StatusTicket::find($idStatusTicket);

      $statusTicket->tickets = [
        'statusTicket' => $statusTicket,
        'relationships' => [
          'links' => [
            'href' => route('api.statusTickets.tickets', ['status_ticket' => $statusTicket->id], false),
            'rel' => class_basename($statusTicket->tickets()->getRelated()),
          ],
          'quantity' => $statusTicket->tickets->count(),
          'collection' => $statusTicket->tickets->map(function ($ticket) {
            return new JsonTicket($ticket);
          })
        ]

      ];

      return $this->response->success($statusTicket->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
