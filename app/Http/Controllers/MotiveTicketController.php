<?php

namespace App\Http\Controllers;

use App\Helpers\MakeResponse;
use App\Http\Resources\Json\MotiveTicket as JsonMotiveTicket;
use App\Http\Resources\Json\Ticket as JsonTicket;
use App\Http\Resources\MotiveTicketCollection;
use App\Models\MotiveTicket;
use Illuminate\Support\Facades\Validator;

class MotiveTicketController extends Controller
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
   * Display a listing of the motive tickets resources.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\MotiveTicketCollection
   * @apiResourceModel App\Models\MotiveTicket
   */
  public function index()
  {

    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $motiveTickets = new MotiveTicketCollection(MotiveTicket::all());

      return $this->response->success($motiveTickets);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\MotiveTicket
   * @apiResourceModel App\Models\MotiveTicket
   */
  public function store()
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $motiveTicket = new MotiveTicket();

      $motiveTicket = $motiveTicket->create(request()->all());

      return $this->response->created($motiveTicket->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $motive_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\MotiveTicket
   * @apiResourceModel App\Models\MotiveTicket
   * 
   * @urlParam motive_ticket required The ID of the motive ticket resource.
   */
  public function show($motive_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($motive_ticket))
        return $this->response->badRequest();

      $motiveTicketModel = MotiveTicket::find($motive_ticket);

      if (!isset($motiveTicketModel))
        return $this->response->noContent();

      return $this->response->success($motiveTicketModel->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $motive_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * @apiResourceCollection App\Http\Resources\Json\MotiveTicket
   * @apiResourceModel App\Models\MotiveTicket
   * 
   * @urlParam motive_ticket required The ID of the motive ticket resource.
   */
  public function update($motive_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($motive_ticket))
        return $this->response->badRequest();

      $motiveTicketModel = MotiveTicket::find($motive_ticket);

      if (!isset($motiveTicketModel))
        return $this->response->noContent();

      $validate = $this->validateData(request()->all());

      if ($validate->fails())
        return $this->response->exception($validate->errors());

      $motiveTicketModel->update(request()->all());

      return $this->response->success($motiveTicketModel->fresh()->format());
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $motive_ticket
   * @return App\Helpers\MakeResponse
   * @authenticated 
   * 
   * @urlParam motive_ticket required The ID of the motive ticket resource.
   */
  public function destroy($motive_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($motive_ticket))
        return $this->response->badRequest();

      $motiveTicketModel = MotiveTicket::find($motive_ticket);

      if (!isset($motiveTicketModel))
        return $this->response->noContent();

      $motiveTicketModel->delete();

      return $this->response->success(null);
    } catch (\Exception $exception) {

      return $this->response->exception($exception->getMessage());
    }
  }

  /**
   * Display a list of tickets resources related to motive ticket resource.
   *
   * @param  int  $motive_ticket
   * @return App\Helpers\MakeResponse
   * 
   * @authenticated 
   * @response {
   *  "motiveTicket": "motiveTicket",
   *  "relationships":{
   *    "links": {"href": "url", "rel": "/rels/tickets"},
   *    "collections": {"numberOfElements": "number", "data": "array"}
   *   }
   * }
   * 
   * @urlParam motive_ticket required The ID of the motive ticket resource.
   */
  public function tickets($motive_ticket)
  {
    try {
      if (!request()->isJson())
        return $this->response->unauthorized();

      if (!is_numeric($motive_ticket))
        return $this->response->badRequest();

      $motiveTicketModel = MotiveTicket::find($motive_ticket);

      if (!isset($motiveTicketModel))
        return $this->response->noContent();

      $motiveTicketFormated = new JsonMotiveTicket($motiveTicketModel);

      $motiveTicketFormated->tickets = [
        'motiveTicket' => $motiveTicketFormated,
        'relationships' => [
          'links' => [
            'href' => route(
              'api.motiveTickets.tickets',
              ['motive_ticket' => $motiveTicketFormated->id],
              false
            ),
            'rel' => '/rels/tickets'
          ],
          'collection' => [
            'numberOfElements' => $motiveTicketFormated->tickets->count(),
            'data' => $motiveTicketFormated->tickets->map(function ($ticket) {
              return new JsonTicket($ticket);
            })
          ]
        ]
      ];

      return $this->response->success($motiveTicketFormated->tickets);
    } catch (\Exception $exception) {
      return $this->response->exception($exception->getMessage());
    }
  }
}
