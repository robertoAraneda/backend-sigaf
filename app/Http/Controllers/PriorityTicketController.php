<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\PriorityTicket as JsonPriorityTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\PriorityTicketCollection;
use App\Models\PriorityTicket;
use Illuminate\Support\Facades\Validator;

class PriorityTicketController extends Controller
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

      $priorityTickets = new PriorityTicketCollection(PriorityTicket::all());

      return $this->response->success($priorityTickets);
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
        return $this->response->exception(($validate->errors()));

      $priorityTicket = new PriorityTicket();

      $priorityTicket = $priorityTicket->create(request()->all());

      return $this->response->created((new JsonPriorityTicket($priorityTicket)));
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

      if (!is_numeric($id))
        return $this->response->badRequest();

      $priorityTicket = PriorityTicket::find($id);

      if (!isset($priorityTicket))
        return $this->response->noContent();

      return $this->response->success($priorityTicket->format());
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

      if (!is_numeric($id))
        return $this->response->badRequest();

      $priorityTicket = PriorityTicket::find($id);

      if (!isset($priorityTicket))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $priorityTicket->update(request()->all());

      return $this->response->success(new JsonPriorityTicket($priorityTicket->fresh()));
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

      if (!is_numeric($id))
        return $this->response->badRequest();

      $priorityTicket = PriorityTicket::find($id);

      if (!isset($priorityTicket))
        return $this->response->noContent();

      $priorityTicket->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function tickets($idPriorityTicket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $priorityTicket = PriorityTicket::find($idPriorityTicket);

      $priorityTicket->tickets = [
        'priorityTicket' => $priorityTicket,
        'relationships' => [
          'links' => [
            'href' => route('api.priorityTickets.tickets', ['priority_ticket' => $priorityTicket->id], false),
            'rel' => '/rels/tickets',
          ],
          'quantity' => $priorityTicket->tickets->count(),
          'collection' => $priorityTicket->tickets->map(function ($ticket) {
            return new JsonTicket($ticket);
          })
        ]
      ];

      return $this->response->success($priorityTicket->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
