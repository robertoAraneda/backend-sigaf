<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\TypeTicketCollection;
use App\Models\TypeTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Json\TypeTicket as TicketResource;

class TypeTicketController extends Controller
{

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
        return MakeResponse::unauthorized();

      $typeTickets = new TypeTicketCollection(TypeTicket::all());

      return MakeResponse::success($typeTickets);
    } catch (\Exception $exception) {

      return MakeResponse::exception($exception->getMessage());
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

      $valitate = $this->validateData(request()->all());

      if ($valitate->fails())
        return MakeResponse::exception($valitate->errors());


      $typeTicket = new TypeTicket();

      $typeTicket = $typeTicket->create(request()->all());

      return MakeResponse::success($typeTicket->format());
    } catch (\Exception $exception) {
      return MakeResponse::exception($exception->getMessage());
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
        return MakeResponse::unauthorized();

      if (!is_numeric($id))
        return MakeResponse::badRequest();

      $typeTicket = TypeTicket::whereId($id)->first();

      if (!isset($typeTicket))
        return MakeResponse::noContent();

      return MakeResponse::success($typeTicket->format());
    } catch (\Exception $exception) {

      return MakeResponse::exception($exception->getMessage());
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

      if (!request()->isJson())
        return MakeResponse::unauthorized();

      if (!is_numeric($id))
        return MakeResponse::badRequest();

      $typeTicket = TypeTicket::whereId($id)->first();

      if (!isset($typeTicket))
        return MakeResponse::noContent();

      $valitate = $this->validateData(request()->all());

      if ($valitate->fails())
        return MakeResponse::exception($valitate->errors());

      $typeTicket->update(request()->all());

      return MakeResponse::success($typeTicket->fresh()->format());
    } catch (\Exception $exception) {

      return MakeResponse::exception($exception->getMessage());
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
        return MakeResponse::unauthorized();

      if (!is_numeric($id))
        return MakeResponse::badRequest();

      $typeTicket = TypeTicket::whereId($id)->first();

      if (!isset($typeTicket))
        return MakeResponse::noContent();

      $typeTicket->delete();

      return MakeResponse::success(null);
    } catch (\Exception $exception) {

      return MakeResponse::exception($exception->getMessage());
    }
  }

  public function tickets($idTypeTicket)
  {

    try {
      if (!request()->isJson())
        return MakeResponse::unauthorized();


      $typeTicket = new TicketResource(TypeTicket::find($idTypeTicket));



      if (!isset($typeTicket))
        return MakeResponse::noContent();

      $typeTicket->tickets = [
        'typeTicket' => $typeTicket,
        'href' => route('api.typeTickets.tickets', ['type_ticket' => $typeTicket->id]),
        'rel' => class_basename($typeTicket->tickets()->getRelated()),
        'tickets' => $typeTicket->tickets->map->format()
      ];

      return MakeResponse::success($typeTicket->tickets);
    } catch (\Exception $exception) {

      return MakeResponse::exception($exception->getMessage());
    }
  }
}
