<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\TypeTicketCollection;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Json\TypeTicket as JsonTypeTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;

class TypeTicketController extends Controller
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

      $typeTickets = new TypeTicketCollection(TypeTicket::all());

      return $this->response->success($typeTickets);
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
        return MakeResponse::unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $typeTicket = new TypeTicket();

      $typeTicket = $typeTicket->create(request()->all());

      return $this->response->created(new JsonTypeTicket($typeTicket));
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

      $typeTicket = TypeTicket::find($id);

      if (!isset($typeTicket))
        return $this->response->noContent();

      return $this->response->success(new JsonTypeTicket($typeTicket));
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

      $typeTicket = TypeTicket::find($id);

      if (!isset($typeTicket))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $typeTicket->update(request()->all());

      return $this->response->success(new JsonTypeTicket($typeTicket->fresh()));
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

      $typeTicket = TypeTicket::find($id);

      if (!isset($typeTicket))
        return $this->response->noContent();

      $typeTicket->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  public function tickets($idTypeTicket)
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $typeTicket = new JsonTypeTicket(TypeTicket::find($idTypeTicket));

      $typeTicket->tickets = [
        'typeTicket' => $typeTicket,

        'url' => route('api.typeTickets.tickets', ['type_ticket' => $typeTicket->id]),

        'href' => route('api.typeTickets.tickets', ['type_ticket' => $typeTicket->id], false),

        'rel' => class_basename($typeTicket->tickets()->getRelated()),

        'count' => $typeTicket->tickets->count(),

        'tickets' => $typeTicket->tickets->map(function ($ticket) {
          return new JsonTicket($ticket);
        })
      ];

      return $this->response->success($typeTicket->tickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }
}
